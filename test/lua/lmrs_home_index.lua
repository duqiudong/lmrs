ngx.header.content_type = "application/json;charset=utf8"
local cache_ngx = ngx.shared.cache;
local contentCache = cache_ngx:get("lmrs_home_index");
local cjson = require("cjson");
if contentCache == "" or contentCache == nil then
    local redis = require("resty.redis");
    local red = redis:new()
    red:set_timeout(2000)
    red:connect("172.27.0.5", 63790)
    local rescontent = red:get("lmrs_home_index");
    if ngx.null == rescontent or null == rescontent or false == rescontent or "" == rescontent then
        local mysql = require("resty.mysql");
        local db = mysql:new();
        --db:set_timeout(2000)
        local props = {
            host = "172.27.0.6",
            port = 33060,
            database = "lmrs_2008_shops",
            user = "root",
            password = "123456"
        }
        local res = db:connect(props);
        local select_sql = "select * from lmrs_product_categorys"
        res = db:query(select_sql);
        local responsejson = cjson.encode(res);
        red:set("lmrs_home_index", responsejson);
        ngx.say(responsejson);
        db:close()
    else
        cache_ngx:set("lmrs_home_index", rescontent, 10 * 60);
        ngx.say(rescontent)
    end
    red:close()
else
    ngx.say(contentCache)
end