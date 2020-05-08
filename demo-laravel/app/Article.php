<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {
	// 配置表名
	protected $table = 'article';

	// 关闭时间自动更新
	public $timestamps = false;

	// 可以批量添加数据
	protected $fillable = ['articleid', 'author', 'content', 'isUp', 'category'];

}
