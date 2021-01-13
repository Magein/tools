### 描述

  个人开发常用的工具类
  
### 目录

 common
 
 > 开发中常用的工具类，不依赖于与任何框架，需php版本大于7.0，直接使用即可
 
 security
 
 >  接口安全工具类
 
 extra
 
 > 依赖第三方扩展的工具类
 
### 工具类文档 

 > 使用方法很简单，就是一些常用的工具
 
#### [UnixTime.php](https://github.com/Magein/tools/blob/master/src/common/UnixTime.php) 

 > 获取各个类型的时间戳
  
 1. unix 时间字符串转化为时间戳  不同于strtotime的是，不会出现负数
 2. begin 获取指定日期的开始时间戳
 3. end  获取指定日期的结束时间戳
 4. today 今天的时间范围
 5. rangeDay   指定的日期时间范围
 6. beginMonth 指定月份的开始时间
 7. endMonth   指定月份的结束时间
 8. rangeMonth 指定月份的时间戳范围
 9. rangeWeek 指定的时间的周范围
 10. prevWeek 最近7天的时间戳范围  这里是传递参数的前七天的时间戳范围
 11. lastWeek 前几周的时间范围，传递2 表示前两周的的时间范围， 3表示前三周的时间范围，即上周，上上周的概念
 
#### [Variable.php](https://github.com/Magein/tools/blob/master/src/common/Variable.php)

 > 命名方式转化
 
 1. transToCamelCase 转化为驼峰命名
 2. transToPascal   转化为帕斯卡命名
 3. transToUnderline 转化为下划线命名
 
 
#### [RandomString.php](https://github.com/Magein/tools/blob/master/src/common/RandomString.php)

 >生成随机字符串 
 
 常量：
 1. TYPE_UPPER 生成大写字母的随机字符串
 2. TYPE_LOWER 生成小写字母的随机字符串
 3. TYPE_NUM 数字
 4. TYPE_UPPER_LOWER 大写加小写
 5. TYPE_UPPER_NUM 大写加数字
 6. TYPE_LOWER_NUM 小写加数字
 7. TYPE_MIXED 混合
 
 方法：
 
 1. make 生成随机字符串，接受三个参数，依次是生成的长度、字符串类型、是否过滤0|o|z|2等容易混淆的字符


#### [ClientIp.php](https://github.com/Magein/tools/blob/master/src/common/ClientIp.php)

 > 获取客户端的ip地址
 
 方法:
 
 1. get
 
#### [Csv.php](https://github.com/Magein/tools/blob/master/src/common/Csv.php)

 > csv导出类
 
 方法:
 1. setHeader  设置表格头部信息  可通过构造方法第一个参数传递
 2. setData    设置表格内容      可通过构造方法第二个参数传递
 3. correcting 校正头部跟内容的位置
 4. readFile  读取文件并导出
 5. export    导出文件
 6. save      保存到指定位置 需要制定完整的路径  如：'xxx/xxx/xxx.csv'、'xxx/xxx/xxx.txt'
 
#### [ImageLocal.php](https://github.com/Magein/tools/blob/master/src/common/ImageLocal.php)

 > 图片保存到本地指定路径
 
 1. pull 下载远程图片到本地
 2. base64 保存base64编码的图片到本地
  
#### [Location.php](https://github.com/Magein/tools/blob/master/src/common/Location.php)

 > 获取经纬度，传递经纬度字符串，不区分经度在前还是纬度在前，自动提取，
 
 <font color="red">仅仅使用与国内的经纬度坐标>_< </font> 
 
####  [JsonToken.php](https://github.com/Magein/tools/blob/master/src/security/JsonToken.php)

 > 接口中常用的jwt验证函数
 
 1. make 生成token  可以传递一个字符串 用于记录自定义的标识信息
 2. verify 验证token
 
#### [XRequestId.php](https://github.com/Magein/tools/blob/master/src/security/XRequestId.php)

 > 自定义的请求验证参数，一般用于接口请求来源验证
 
 1. make 生成
 2. verify 验证
 
#### [MsgDeliver.php](https://github.com/Magein/tools/blob/master/src/common/MsgDeliver.php)

 > 消息传递器，使用单列模式，即用型，用户设定一些错误、或者验证信息
 
 1. set 设置
 2. get 获取
 3. clear 清除 
 
#### [TreeStructure.php](https://github.com/Magein/tools/blob/master/src/common/TreeStructure.php)

 > 数组处理成树结构
 
 ```php
$data = [
    [
        'id' => 1,
        'title' => '第一个',
        'pid' => 0
    ],
    [
        'id' => 2,
        'title' => '第二个',
        'pid' => 0
    ],
    [
        'id' => 3,
        'pid' => 1,
        'title' => '第一个的子集'
    ],
    [
        'id' => 4,
        'pid' => 1,
        'title' => '第一个的子集'
    ],
    [
        'id' => 5,
        'pid' => 2,
        'title' => '第二个的子集'
    ],
    [
        'id' => 6,
        'pid' => 2,
        'title' => '第二个的子集'
    ],
    [
        'id' => 7,
        'pid' => 5,
        'title' => '第二个的子集的子集'
    ]
];

// 第一个参数是要处理的数据  第二个参数是关联字段（默认pid）  第三个是主键（默认id）
$tree = new TreeStructure($data, 'pid', 'id');
// 可传递一个回调函数，用于其他逻辑
$result = $tree->tree();
var_dump($result);
```

#### [RegVerify.php](https://github.com/Magein/tools/blob/master/src/common/RegVerify.php)

 > 常用的验证字段正则表达式
 
 1. phone 验证手机号码
 2. email 验证email
 3. qq 验证qq
 4. idCard 验证字符串
 5. url 验证是否是链接  必须包含 http或者https
 6. ip 验证ip
 7. password 密码  数字字母下划线6到18位
 8. image 验证是否是图片 只验证ext 允许的格式jpg、jpeg、gif、png
 
 