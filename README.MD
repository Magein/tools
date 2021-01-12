### 描述

  个人开发常用的工具类
  
### 目录

 1. common
 2. extra
 
### common 

 > 开发中常用的工具类，依赖于与任何框架，需php版本大于7.0，直接使用即可
 
#### UnixTime.php 

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
 
#### Variable.php

 > 命名方式转化
 
 1. transToCamelCase 转化为驼峰命名
 2. transToPascal   转化为帕斯卡命名
 3. transToUnderline 转化为下划线命名
 
 
#### RandomString.php

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


#### ClientIp.php

 > 获取客户端的ip地址
 
 方法:
 
 1. get
 
#### Csv.php

 > csv导出类
 
 方法:
 1. setHeader  设置表格头部信息  可通过构造方法第一个参数传递
 2. setData    设置表格内容      可通过构造方法第二个参数传递
 3. correcting 校正头部跟内容的位置
 4. readFile  读取文件并导出
 5. export    导出文件
 6. save      保存到指定位置 需要制定完整的路径  如：'xxx/xxx/xxx.csv'、'xxx/xxx/xxx.txt'