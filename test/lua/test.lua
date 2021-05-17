ngx.header.content_type = "application/json;charset=utf8"

local x=ngx.shared.cache
-- 在共享内存里放个kv对
x:set("a","apple")
ngx.say("STOREDS")

-- 获取数据
ngx.say(x:get("a"))