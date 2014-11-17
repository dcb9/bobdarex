XML="<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1348831860</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[maps maroon5]]></Content>
</xml>"

echo $XML | curl -X POST -H 'Content-type: text/xml' -d @- 'http://weixin.bobdarex.phpor.me?signature=09cc2c33a62fbc988a428f4039488b138ffb5777&timestamp=1416195353&nonce=123456'
# http://blog.csdn.net/aust_niuroutang/article/details/7536861
