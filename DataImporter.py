import pymongo
from pymongo import MongoClient, IndexModel
import csv

client = MongoClient()
db = client.HW4

db.tourneys.drop()
db.matches.drop()
db.players.drop()
# index1 = IndexModel([('tourn_name', pymongo.ASCENDING)])
# index2 = IndexModel([('date',pymongo.ASCENDING)])
# index3 = IndexModel([('match_num',pymongo.ASCENDING)])
# index4 = IndexModel([('tourn_id', pymongo.ASCENDING)])
# tourn_result = db.tourneys.create_indexes([index1,index2], unique=True)
# match_result = db.tourneys.create_indexes([index3,index4], unique=True)
# player_result = db.players.create_index([('name', pymongo.ASCENDING)], unique=True)
tourn_result = db.tourneys.create_index([('tourn_name', pymongo.ASCENDING),('date',pymongo.ASCENDING)], unique=True)
match_result = db.matches.create_index([('match_num', pymongo.ASCENDING),('tourn_id', pymongo.ASCENDING)], unique=True)
player_result = db.players.create_index([('name', pymongo.ASCENDING)], unique=True)
# tourn_id = 0
# winner_id = 0
# loser_id = 0
def parse_csv(filename):
    with open(filename, 'r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=',')
        next(csv_reader)
        for row in csv_reader:
            tourn_name = row[1]
            # print(tourn_name)
            surface = row[2]
            date = row[5]
            match_num =row[6]
            winner = row[10]
            winner_hand = row[11]
            winner_ht = row[12]
            winner_ioc = row[13]
            winner_age = row[14]
            winner_rank = row[15]
            loser = row[20]
            loser_hand = row[21]
            loser_ht = row[22]
            loser_ioc = row[23]
            loser_age = row[24]
            loser_rank = row[25]
            score = row[27]
            best_of = row[28]
            rnd = row[29]
            tourney = {"tourn_name": tourn_name, "date": date, "surface": surface}
            # match = {"tourn_name": tourn_name, "match_num": match_num, "date":date, 
            # "winner": winner, "winner_rank": winner_rank, "loser": loser, 
            # "loser_rank": loser_rank, "score": score}
            win = {"name": winner, "hand": winner_hand, "height": winner_ht, "country": winner_ioc}
            lose = {"name": loser, "hand": loser_hand, "height": loser_ht, "country": loser_ioc}
            # tourn_result = db.tourneys.create_index([('tourn_name', pymongo.DESCENDING)], unique=True)
            try:
                tourn_id = db.tourneys.insert_one(tourney).inserted_id
            except pymongo.errors.DuplicateKeyError:
                tourn_id = db.tourneys.find_one({"tourn_name":tourn_name, "date":date})
                tourn_id = tourn_id.get('_id')
                pass

            try:
                winner_id = db.players.insert_one(win).inserted_id
            except pymongo.errors.DuplicateKeyError:
                winner_id = db.players.find_one({"name": winner})['_id']
                pass
            try:
                loser_id = db.players.insert_one(lose).inserted_id
            except pymongo.errors.DuplicateKeyError:
                loser_id = db.players.find_one({"name": loser})['_id']
                pass

            match = {"tourn_id": tourn_id, "match_num": match_num, "date":date, 
            "winner": winner_id, "winner_rank": winner_rank, "loser": loser_id, 
            "loser_rank": loser_rank, "score": score}

            try:
                result2 = db.matches.insert_one(match).inserted_id
            except pymongo.errors.DuplicateKeyError:
                pass

        
            
def main():
    for i in range(1968, 2019):
        filename = './match_data/atp_matches_' + str(i) +'.csv'
        print(filename)
        parse_csv(filename)

if __name__ == "__main__":
    main()