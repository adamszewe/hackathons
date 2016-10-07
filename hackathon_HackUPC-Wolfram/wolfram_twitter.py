# @author Adam Szewera
# get streem from twitter and print it out - then send it to wolfram and get in response the main places to
# visit

from urllib import urlencode
from urllib2 import urlopen
import twitter 
import re
import operator
import sys


class WolframCloud:

    def wolfram_cloud_call(self, **args):
        arguments = dict([(key, arg) for key, arg in args.iteritems()])
        result = urlopen("http://www.wolframcloud.com/objects/e41033e5-9612-4e54-b523-ad886925f1ce", urlencode(arguments))
        return result.read()

    def call(self, text):
        textresult =  self.wolfram_cloud_call(text=text)
        return textresult



def fractionToFloat(s):
    num, den = s.split('/')
    return float(num) / float(den) 





if __name__ == "__main__":
    
    twitterScreenName = 'linkinpark'

    if len(sys.argv) == 2:
        twitterScreenName = sys.argv[1]
    print("twitter: " + twitterScreenName)

    api = twitter.Api(
            consumer_key='Ennd4ODhrdpWdBGBG7O6IBpmJ',
            consumer_secret='iQG0DcWYdI6262uYq7xMECFcVr3tqrwLCLjQkuFc5GCXE39DL5',
            access_token_key='700905539820191744-5aKTXBMhHw2Y3MizfREx2OQtvvvUPcC',
            access_token_secret='dckZYIjDWuVo7LmHmt8pGw1GkArkC1vTeQlPlOo41OQT7'
    )

    #print(api.VerifyCredentials())

    statuses = api.GetUserTimeline(screen_name=twitterScreenName)
    textStatuses = [s.text for s in statuses]

    theText = ""
    for text in textStatuses:
        text = text.encode("UTF-8")
        result = re.sub(r"http\S+", "", text)
        theText += result

    a = WolframCloud()
    result = a.call(theText)
    result = result[1:-1].split(',')


    # they are returned in a special order
    result = map(fractionToFloat, result)
    location2Index = {
            "Sagrada Familia" : result[0],
            "Museu Picasso" : result[1],
            "Park Guell" : result[2],
            "Hard Rock Cafe" : result[3],
            "Camp Nou" : result[4]
    }

    sortedLocation = sorted(location2Index.items(), key=operator.itemgetter(1))

    json = """{"""

    # iterate on the reversed list
    for k,v in sortedLocation[::-1]:
        print("%s:\t%.2f%%" % (k, 100 * v))
        json += '"%s":%.4f,' % (k, 100 * v)

    json = json[0:-1]   # remove the last comma
    json += "}"
    print(json)


