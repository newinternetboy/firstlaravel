<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Diff</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
        .coolscrollbar{
            scrollbar-arrow-color:yellow;
            scrollbar-base-color:lightsalmon;
            overflow:scroll;
            width:200px;
            height:200px;
        }

        .question{
            background-color: #34ce57;
            height:260px;
            margin-top:20px;
        }

        .model{
            background-color: #b8daff;
            height:260px;
            margin-top:20px;

        }
        .actrul_record{
            background-color: pink;
            height:260px;
            margin-top:20px;
        }
    </style>
</head>
<body>
<div id="container">
    @if(isset($error))
    <div class="alert alert-danger" role="alert">
            {{ $error }}
    </div>
    @endif
    <div>
        <form class="form-inline" method="post" action="/diff">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="form-group">
                <label for="uid">uid</label>
                @if(isset($request['uid']))
                <input type="text" class="form-control" id="uid" name="uid" placeholder="请输入uid" value="{{ $request['uid'] }}">
                @else
                <input type="text" class="form-control" id="uid" name="uid" placeholder="请输入uid">
                @endif
            </div>
            <div class="form-group">
                <label for="fid">fid</label>
                @if(isset($request['uid']))
                <input type="text" class="form-control" id="fid" name="fid" placeholder="请输入fid" value="{{ $request['fid'] }}">
                @else
                <input type="text" class="form-control" id="fid" name="fid" placeholder="请输入fid">
                @endif
            </div>
            <div class="form-group">
                <label for="diff_page">diff_page</label>
                @if(isset($request['diff_page']))
                <input type="text" class="form-control" id="diff_page" name="diff_page" placeholder="页码" value="{{ $request['diff_page'] }}">
                @else
                <input type="text" class="form-control" id="diff_page" name="diff_page" placeholder="页码">
                @endif
            </div>
            <div class="form-group">
                <select name="diff_page_size" id="diff_page_size">
                    @foreach([10,20,30] as $v)
                    @if(isset($request['diff_page_size']) && $request['diff_page_size'] == $v)
                    <option value="{{ $v }}" selected>{{ $v }}</option>
                    @else
                    <option value="{{ $v }}">{{ $v }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-default">Search</button>
        </form>
    </div>
    @if(isset($result))
    <div class="row" style="background:green;height:30px">
        <div class="col-lg-4" >uid</div>
        <div class="col-lg-4" >介绍</div>
        <div class="col-lg-4" >机构图片</div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3">
            {{ $result['industryInfo']['uid'] }}
        </div>
        <div class="col-lg-4 col-md-3">
            {{  $result['industryInfo']['intro'] }}
        </div>
        <div class="col-lg-4 col-md-3">
            <a href="#" class="thumbnail">
                <img src="{{  $result['industryInfo']['avatar'] }}" alt="">
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4" style="background:#34ce57">用户 fid 问题</div>
        <div class="col-lg-4" style="background:#b8daff">模型自动回复</div>
        <div class="col-lg-4" style="background:pink">实际聊天记录</div>
    </div>
    @foreach($result['data'] as $key=>$value)
    @if($key % 2 == 0)
    <div class="row">
        <div class="col-lg-4 question">
            时间：{{ $value['createDate'] }}<br />
            uid：{{ $value['uid'] }}<br />
            fid：{{ $value['fid'] }}<br />
            问题：{{ $value['msginfo_content'] }}<br />
            类型：{{ $value['type'] }}<br />
        </div>
        <div class="col-lg-4 model"><textarea class="coolscrollbar">{!! $value['questionAnswerInfoListQA'] !!}</textarea></div>
        <div class="col-lg-4 actrul_record">{!! $value['record'] !!}</div>
    </div>
    @else
    <div class="row">
        <div class="col-lg-4 question">
            时间：{{ $value['createDate'] }}<br />
            uid：{{ $value['uid'] }}<br />
            fid：{{ $value['fid'] }}<br />
            问题：{{ $value['msginfo_content'] }}<br />
            类型：{{ $value['type'] }}<br />
        </div>
        <div class="col-lg-4 model"><textarea class="coolscrollbar">{!! $value['questionAnswerInfoListQA'] !!}</textarea></div>
        <div class="col-lg-4 actrul_record">{!! $value['record'] !!}</div>
    </div>
    @endif
    @endforeach
    @endif
</div>
</body>
</html>
