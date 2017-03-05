#!/usr/bin/env python

from PIL import Image, ImageDraw, ImageFont
import hashlib
import random
import math




def hexHash(str, withHash = None):
    h = hashlib.md5()
    h.update(str)
    if withHash != None:
        return h.hexdigest()
    else:
        return '#'+h.hexdigest()

def center(diameter, imageWidth):
    topCorner = imageWidth / 2 - diameter / 2
    botCorner = imageWidth / 2 + diameter / 2
    return topCorner, topCorner, botCorner, botCorner

def createArc(image, diameter, imageWidth, start, end, color, thickness, hole):
    draw = ImageDraw.Draw(image)
    draw.pieslice(center(diameter, imageWidth), start, end, fill=color)
    draw.pieslice(center(diameter - thickness, imageWidth), start, end, fill=hole)
    del draw

def luminance(Hex):
    if Hex[0] == '#':
        Hex = Hex[1:7]
    r = int(Hex[0:2], 16)
    g = int(Hex[2:4], 16)
    b = int(Hex[4:6], 16)
    return math.sqrt( math.pow(0.241*r, 2) + math.pow(0.691*g, 2) + math.pow(0.068*b, 2) )

def generateImage(STR, path, size, fontPath):
    size = int(size)
    s = size*4
    color1range = 0
    color2range = 0
    color1 = hexHash(STR)[color1range:color1range+7]
    color2 = hexHash(STR + 'background')[color2range:color2range+7]
    print 'init colors:', color1, color2

    correctContrast = False
    while correctContrast == False:
        if luminance(color1) > luminance(color2) + 70 or luminance(color1) < luminance(color2) - 70:
            correctContrast = True
        else:
            try:
                color2range += 1
                color2 = '#'+ hexHash(STR)[color2range:color2range+6]
            except Exception as e:
                color1range += 1
                color1 = '#'+ hexHash(STR)[color1range:color1range+6]
                color2range += 1
                color2 = '#'+ hexHash(STR)[color2range:color2range+6]


    image = Image.new("RGB", (s, s), color1)
    draw = ImageDraw.Draw(image)


    #draw.ellipse(
    #    center(s/1.1,s),
    #    fill = color2,
    #    outline = color2
    #)
    #draw.ellipse(
    #    center(s/1.2,s),
    #    fill = color1,
    #    outline = color1
    #)
    #
    #a1 = random.randint(-180, 180)
    #a2 = a1 + random.randint(70, 170)
    #
    #a3 = a1 * -1
    #a4 = a3 + random.randint(70, 170)
    #
    #a5 = a3 * -1
    #a6 = a5 + random.randint(70, 170)
    #
    #createArc(image, s/1.3, s, a1, a2, color2, s/20.48, color1)
    #createArc(image, s/1.47, s, a3, a4, color2, s/20.48, color1)
    #createArc(image, s/1.7, s, a5, a6, color2, s/20.48, color1)

    fontSize = int(s)
    font = ImageFont.truetype(fontPath, fontSize)
    fs = font.getsize(STR[0].upper())
    x = s/2 - fs[0] /2
    y = s/2 - fs[1] /1.6
    draw.text((x,y ), STR[0].upper(), color2, font=font)

    image.thumbnail((size,size), Image.ANTIALIAS)
    image.save(path, 'JPEG')
    print  "Image Successfully Created"
    return "Image Successfully Created"



#generateImage('Zeb', '/Users/zeb/_Code/image4.jpg', 512)


if __name__ == '__main__':
    import sys
    a = sys.argv
    generateImage(a[1], a[2], a[3], a[4])
    # print "hello"
