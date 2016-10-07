from urllib import urlencode
from urllib2 import urlopen

class WolframCloud:

    def wolfram_cloud_call(self, **args):
        arguments = dict([(key, arg) for key, arg in args.iteritems()])
        result = urlopen("http://www.wolframcloud.com/objects/e9a0e41f-120a-4d54-925a-835108932fde", urlencode(arguments))
        return result.read()

    def call(self, image):
        textresult =  self.wolfram_cloud_call(image=image)
        return textresult


a = WolframCloud()
result = a.call('https://www.petfinder.com/wp-content/uploads/2012/11/dog-how-to-select-your-new-best-friend-thinkstock99062463.jpg')
print(result)
