#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Name:目录爆破插件
# Descript:根据内置字典爆破目录
import os
class webdir:
    def __init__(self,root,threadNum):
        self.root = root
        self.threadNum = threadNum
    def _httpGet(self,url):
        ls_url = self.root + url
        code, head, body, redirect, log = w8_Common.get(ls_url)
        if(code!=404):
            # print "[%s]%s"%(code,ls_url)
            report.add_list("Dirburt",ls_url)

    def run(self):
        code, head, body, redirect, log = w8_Common.get("%s/py/data/dir.txt"%_B)
        if(code==200):
            dictionary = body.split(os.linesep)
            w8_Common.thread(self._httpGet,dictionary,self.threadNum)
            
print "[...] Initialize DIRBURST ..."
ww = webdir(_U,25)
ww.run()
report.send()
print "[...] STOP DIRBURST"