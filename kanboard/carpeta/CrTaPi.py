import http.client

conn = http.client.HTTPConnection("10.129.20.177")

payload = "{ \"jsonrpc\": \"2.0\", \"method\": \"createTask\", \"id\": 1176509098, \"params\": { \"owner_id\": 1, \"creator_id\": 0, \"date_due\": \"\", \"description\": \"JSON ROJAS\", \"category_id\": 0, \"score\": 0, \"title\": \"Test\", \"project_id\": 11, \"color_id\": \"green\", \"column_id\": 42, \"recurrence_status\": 0, \"recurrence_trigger\": 0, \"recurrence_factor\": 0, \"recurrence_timeframe\": 0, \"recurrence_basedate\": 0 } }"

headers = {
    'content-type': "application/json",
    'authorization': "Basic anNvbnJwYzphZWUzYzQ0YmZhZTJiZTg2MDRjYjU2MGQ5MDdiM2E3M2ViZjE4OTY4OWM0YTQ1ZDY0YTdmNmExYWY1Yzc=",
    'cache-control': "no-cache",
    'postman-token': "d3aded14-fe90-ce46-1af1-c07e2ce87dce"
    }

conn.request("POST", "/kanboard/jsonrpc.php", payload, headers)

res = conn.getresponse()
data = res.read()

print(data.decode("utf-8"))
