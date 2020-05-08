##### 地址配置

* 测试地址：xxxx
* 测试端口：xxxx
* 线上地址：xxxx
* 线上端口：xxxx

##### 请求配置

* 请求：post
* body： json
* 响应：json

##### 响应体

```shell
{"errCode":0, "errMsg":"新增成功", "data":[]}
```

| 参数    | 类型   | 说明                                                         |
| :------ | ------ | ------------------------------------------------------------ |
| errCode | Int    | 响应状态码，0表示成功，非0详情请查看<font color="red">【状态码】</font>表 |
| errMsg  | String | 成功/错误信息                                                |
| data    | Array  | 返回数据集合 errCode !=0 时不返回                            |

##### 响应状态码表

| 状态码 | 说明         |
| ------ | ------------ |
| 0      | 接口请求成功 |
| 10001  | 请求参数有误 |
| 10004  | 操作失败     |
| 10005  | 接口内部错误 |

##### 示例

​    新增文章接口名称：aritcle/add

​    Url = 测试/线上地址+测试/线上端口+接口名称

```shell
​```
curl -H "Content-Type:application/json" -X POST -d '{"userid":"bskd343dkfs342342","content":"laravel"}' http://www.demo.com:8080/article/add
​```
```

​    返回

```shell
{"errCode":0, "errMsg":"新增成功"}
```

##### 接口列表

* **新增文章**

​    【接口名称】/article/add

​    【请求参数】     

| 参数     | 类型(长度) | 说明                            | 说明                                                         |
| -------- | :--------- | ------------------------------- | ------------------------------------------------------------ |
| author   | String(50) | <font color="red">**Y**</font>  | 文章作者                                                     |
| content  | String     | <font color="red">**Y**</font>  | 文章内容                                                     |
| category | Int(2)     | <font color="gred">**N**</font> | 文章所属专题 0：其它，1：热门，2：新闻，3：搞笑，4：情感 （前端会先获取专题列表再传入专题ID）<font color="red">**默认其它：0**</font> |
| isUp     | Int(2)     | <font color="gred">**N**</font> | 是否置顶 0：否，1：是 <font color="red">**默认否：0**</font> |

​    【接口响应方式】

```shell
{"errCode":0, "errMsg":"新增成功"} 
```

* **编辑文章**

​    【接口名称】/article/edit

​    【请求参数】

| 参数      | 类型(长度) | 是否必须                        | 说明                      |
| --------- | ---------- | ------------------------------- | ------------------------- |
| articleid | String(32) | <font color="red">**Y**</font>  | 文章ID                    |
| author    | String(50) | <font color="red">**Y**</font>  | 文章作者                  |
| content   | text       | <font color="gred">**N**</font> | 文章内容 无修改可不传     |
| category  | Int(2)     | <font color="gred">**N**</font> | 文章所属专题 无修改可不传 |
| isUp      | Int(2)     | <font color="gred">**N**</font> | 是否置顶 无修改可不传     |

​    【接口响应方式】

```shell
{"errCode":0, "errMsg":"新增成功"} 
```

* **删除文章**

​    【接口名称】/article/del

​    【请求参数】

| 参数      | 类型（长度） | 是否必须                       | 说明   |
| --------- | ------------ | ------------------------------ | ------ |
| articleid | String(32)   | <font color="red">**Y**</font> | 文章ID |

​    【接口响应方式】

```shell
{"errCode":0, "errMsg":"新增成功"} 
```

* **文章列表**

​    【接口名称】/article/list

​    【请求参数】

| 参数       | 类型（长度） | 是否必须                        | 说明                                                         |
| ---------- | ------------ | ------------------------------- | ------------------------------------------------------------ |
| isUp       | Int(2)       | <font color="gred">**N**</font> | where isUp                                                   |
| category   | Int(2)       | <font color="gred">**N**</font> | where category                                               |
| descColumn | String(10)   | <font color="gred">**N**</font> | 排序字段 支持：newest_time最新回复时间，updated_at更新时间， created_at创建时间 |
| descRule   | String(4)    | <font color="gred">**N**</font> | 排序规则 支持：desc倒序，asc正序                             |
| page       | Int(10)      | <font color="gred">**N**</font> | 页码 需要分页时必传                                          |
| pageSize   | Int(10)      | <font color="gred">**N**</font> | 每页条数 默认10条                                            |

​    【接口响应方式】

```shell
{"errCode":0, "errMsg":"新增成功", "data":[{"articleid":"858a614c14c22634f49fcbf3ec74a4bc","category":0,"isUp":1,"author":"xxxxx","content":"yyyyyy","newest_time":"2021-05-05 00:00:00","created_at":"2021-05-05 00:00:00","updated_at":"2021-05-05 00:00:00"}]} 
```

​    【响应参数data】

| 参数        | 说明         |
| ----------- | ------------ |
| articleid   | 文章ID       |
| category    | 文章所属专题 |
| isUp        | 是否置顶     |
| author      | 文章作者     |
| content     | 文章内容     |
| newest_time | 最新回复时间 |
| created_at  | 创建时间     |
| updated_at  | 更新时间     |

