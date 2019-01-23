<?php
/**
 * Created by IntelliJ IDEA.
 * User: philipp
 * Date: 2019-01-08
 * Time: 09:53
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class DiffController extends Controller
{
    private $type = [
        1 => '文字',
        2 => '图片',
        6 => '商品',
        9 => '日历'
    ];
    private $request_field = [
        'uid','fid','diff_page','diff_page_size'
    ];
    public function index(Request $request){
        if($request->isMethod('post')){
            $return_data = [];
            $request_data = $request->input();
            foreach ($this->request_field as $v){
                if(in_array($v,['uid','fid']) && !isset($request_data[$v])){
                    return view('diff',['error'=>'uid和fid不能为空','request'=>$request_data]);
                }
                $request_data['diff_page'] = isset($request_data['diff_page']) ? $request_data['diff_page'] : 1;
                $request_data['diff_page_size'] = isset($request_data['diff_page_size']) ? $request_data['diff_page_size'] : 10;
            }
            unset($request_data['_token']);
            $result = $this->sendRequest(json_encode($request_data));
            $return_data['industryInfo'] = $result['industryInfo'];
            $data = [];
            foreach($result['modelDiffInfoList'] as $key => $value){
                //处理questionAnswerInfoList中的问题和答案，拼接在一起
                $deal = [];
                $questionAnswerInfoListQA='';
                $records = '';
                $deal['msginfo_content'] = $value['msgInfo']['content'];
                $deal['fid'] = $value['msgInfo']['fid'];
                $deal['uid'] = $value['msgInfo']['uid'];
                $deal['type'] = $value['msgInfo']['type'];
                $deal['createDate'] = date('Y-m-d H:i:s',(int)substr($value['msgInfo']['createDate'],0,-3));
                foreach ($value['chatResult']['data']['questionAnswerInfoList'] as $qaInfokey=>$qaInfovalue){
                    //question
                    $questionAnswerInfoListQA .= $this->type[$qaInfovalue['question']['type']].'-Q:'.$qaInfovalue['question']['content']."\n";
                    foreach($qaInfovalue['answers'] as $qakey => $qa_answer){
                        $questionAnswerInfoListQA .= $this->type[$qa_answer['entityInfos'][0]['type']]."-A".($qakey+1).":".$qa_answer['entityInfos'][0]['content']."\n";
                    }
                }
                $questionAnswerInfoListQA .= "\n";
                //sentenceInfoList
                foreach($value['chatResult']['data']['sentenceInfoList'] as $sk => $sv){
                    foreach ($sv['relatedSentences'] as $entity_key => $entity_value){
                        foreach ($entity_value['entityInfos'] as $eninfokey => $eninfovalue){
                            $questionAnswerInfoListQA .= $this->type[$eninfovalue['type']].'-'.$eninfovalue['content']."\n";
                        }
                    }
                }
                $deal['questionAnswerInfoListQA'] = $questionAnswerInfoListQA;
                foreach ($value['records'] as $rk => $rv){
                    if($rv['current'] ==1){
                        $records .= date("Y-m-d H:i:s",substr($rv['createDate'],0,-3))."-".$this->type[$rv['type']].':<font color="red">'.$rv['content'].'</font>'."<br />";
                    }else{
                        $records .= date("Y-m-d H:i:s",substr($rv['createDate'],0,-3))."-{$this->type[$rv['type']]}:".$rv['content']."<br />";
                    }
                }
                $deal['record'] = $records;
                array_push($data,$deal);
            }
            $return_data['data'] = $data;
            //"<font color='".$color."'>".$value1."</font>"
            return view('diff',['request'=>$request_data,'result'=>$return_data]);
        }else{
            return view('diff');
        }
    }

    public function sendRequest($data){
        $url = "http://172.16.16.107:8085/chat/getChatAssistantDiffRest";
        $header = [
            'Content-Type: application/json',
            'Cache-Control: no-cache'
        ];
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }
}