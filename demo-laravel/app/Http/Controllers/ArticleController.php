<?php
/**
 * 文章类控制器
 * @author   dabing
 * @version  1.0
 */

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArticleController extends Controller {
	// 响应结构体
	private $result = ['errCode' => 0, 'errMsg' => '未知错误', 'data' => []];

	/**
	 * 文章新增/编辑
	 * @param json
	 * {
	 *  'article':"xx"  文章ID 编辑时必传
	 *  'author':"xxx"  文章作者
	 *  'content':"xxx" 文章内容
	 *  'category':0    文章所属类别
	 *  'isUp':0        文章是否置顶
	 * }
	 * @return response json
	 */
	public function article(Request $request) {
		$operation = '新增';

		// 参数校验
		$Rules = [
			'author' => 'required|max:50',
			'content' => 'required',
			'category' => [
				'numeric',
				Rule::in([0, 1, 2, 3, 4]),
			], // 这里的category应该是配置文件中配置
			'isUp' => [
				'numeric',
				Rule::in([0, 1]),
			],
		];

		$data = $request->all();
		if ($request->articleid) {
			$operation = '编辑';

			// 添加对articleid校验
			$Rules['articleid'] = [
				'required',
				'max:32',
				Rule::exists('article')->where(function ($query) use ($request) {
					$query->where('articleid', $request->articleid);
				}),
			];
		} else {
			$data['articleid'] = MD5(uniqid());
		}

		$validate = Validator::make($request->all(), $Rules);
		if ($validate->fails()) {
			$this->result = [
				'errCode' => 10001,
				'errMsg' => $validate->errors()->all(),
			];
			return response()->json($this->result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
		}

		$this->result = [
			'errCode' => 0,
			'errMsg' => $operation . '成功!',
		];

		if ($request->articleid) {
			$res = Article::where('articleid', '=', $request->articleid)->update($data);
			if ($res < 1) {
				$this->result = [
					'errCode' => 10005,
					'errMsg' => '编辑失败！',
				];

			}
		} else {
			$res = Article::create($data);
			if (!$res) {
				$this->result = [
					'errCode' => 10005,
					'errMsg' => '新增失败！',
				];
			}
		}

		return response()->json($this->result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
	}

	/**
	 * 文章删除
	 * @param json
	 * {
	 *   "articleid":"xxx" //文章ID
	 * }
	 * @return response json
	 */
	public function delArticle(Request $request) {
		$validate = Validator::make($request->all(),
			[
				'articleid' => [
					'required',
					'max:32',
					Rule::exists('article')->where(function ($query) use ($request) {
						$query->where('articleid', $request->articleid);
					}),
				],
			]
		);
		if ($validate->fails()) {
			$this->result = [
				'errCode' => 10001,
				'errMsg' => $validate->errors()->all(),
			];
			return response()->json($this->result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
		}

		$res = Article::where('articleid', '=', $request->articleid)->delete();
		if ($res < 1) {
			$this->result = [
				'errCode' => 10001,
				'errMsg' => '删除失败！',
			];
		}
		$this->result = [
			'errCode' => 0,
			'errMsg' => '删除成功!',
		];

		return response()->json($this->result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
	}

	/**
	 * 文章列表
	 * @param json
	 * {
	 *    "isUp":0                      // where isUp 是否置顶文章
	 *    "category":1                  // where category 指定专题
	 *    "descColumn":"newest_time"    // 排序字段 默认：更新时间 有且仅有：newest_time最新回复时间 updated_at更新时间 created_at创建时间
	 *    "descRule":"desc"             // 排序规则 默认倒序 desc倒序 asc正序
	 *    "page":1                      // 当前页码 默认1
	 *    "pageSize":10                 // 每页条数 默认10条
	 * }
	 */
	public function listArticle(Request $request) {
		$validate = Validator::make($request->all(),
			[
				'isUp' => [
					'numeric',
					Rule::in([0, 1]),
				],
				'category' => [
					'numeric',
					Rule::in([0, 1, 2, 3, 4]),
				],
				'descColumn' => [
					Rule::in(['newest_time', 'updated_at', 'created_at']),
				],
				'descRule' => [
					Rule::in(['desc', 'asc']),
				],
				'page' => 'numeric',
				'pageSize' => 'numeric',
			]
		);
		if ($validate->fails()) {
			$this->result = [
				'errCode' => 10001,
				'errMsg' => $validate->errors()->all(),
			];
			return response()->json($this->result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
		}

		$page = 1;
		$pageSize = 10;
		if ($request->has('page')) {
			$page = (int) $request->page;
		}
		if ($request->has('pageSize')) {
			$pageSize = (int) $request->pageSize;
		}
		$where = [];
		if ($request->has('isUp')) {
			$where[] = ['isUp', '=', (int) $request->isUp];
		}
		if ($request->has('category')) {
			$where[] = ['category', '=', (int) $request->category];
		}
		$descColumn = 'updated_at';
		if ($request->has('descColumn')) {
			$descColumn = trim($request->descColumn);
		}
		$descRule = 'desc';
		if ($request->has('descRule')) {
			$descRule = trim($request->descRule);
		}

		$list = Article::where($where)
			->orderBy($descColumn, $descRule)
			->offset(($page - 1) * $pageSize)->limit($pageSize)
			->get()->toArray();

		$this->result = [
			'errCode' => 0,
			'errMsg' => '',
			'data' => array_values($list),
		];

		return response()->json($this->result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
	}
}
