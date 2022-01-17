<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_3-5</title>
    </head>
    <body>
<?php
    $a="";
    $b="";
    $c="";
    $d="";
    $name=$_POST["name"];
    $comment=$_POST["comment"];
    $del_num=$_POST["del_num"];
    $pwd=$_POST["pwd"];
    $del_pwd=$_POST["del_pwd"];
    $edit_pwd=$_POST["edit_pwd"];
    $date=date("Y/m/d H:i:s");
    $filename="mission_3-5.txt";
    $edit_num=$_POST["edit_num"];
    $numbox=$_POST["numbox"];
    
    //編集関連処理
    if($edit_num && $edit_pwd){
        if(file_exists($filename)){
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            $fp=fopen($filename,"a");
            foreach($lines as $line){
                $word=explode("<>",$line);
                if($edit_num==$word[0]){
                    if($edit_pwd==$word[4]){
                        $a=$word[0];
                        $b=$word[1];
                        $c=$word[2];
                        $d=$word[4];
                    }
                }
            }
        }
    }
?>

        <form method="post">
            <input type="hidden" name="numbox" value="<?php echo $a;?>">
            <input type="text" name="name" placeholder="名前" value="<?php echo $b;?>"><br>
            <input type="text" name="comment" placeholder="コメント" value="<?php echo $c;?>"><br>
            <input type="text" name="pwd" placeholder="パスワード" value="<?php echo $d;?>">
            
            <input type="submit" name="submit"><br><br>
            <input type="number" name="del_num" placeholder="削除対象番号"><br>
            <input type="text" name="del_pwd" placeholder="パスワード">
            <input type="submit" name="delete" value="削除"><br><br>
            <input type="number" name="edit_num" placeholder="編集対象番号"><br>
            <input type="text" name="edit_pwd" placeholder="パスワード">
            <input type="submit" name="edit" value="編集"><br><br>
            </form>
            
        <?php

            //ファイルに保存する処理
            if($name && $comment && $pwd){
                if($numbox){   //編集内容投稿処理
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    $fp=fopen($filename,"w+");
                    foreach($lines as $line){
                        $word=explode("<>",$line);
                        if($numbox==$word[0]){
                            fwrite($fp,$numbox."<>".$name."<>".$comment."<>".$date."<>".$pwd."<>".PHP_EOL);
                        }else{
                            fwrite($fp,$line.PHP_EOL);
                        }
                    }
                    fclose($fp);
                }else{    //新規投稿処理
                    if(file_exists($filename)){
                        $lines=file($filename,FILE_IGNORE_NEW_LINES);
                        $last=count($lines);     //行数をカウント
                        $lastline=$lines[$last-1];    //最後の行の要素数
                        $word=explode("<>",$lastline);    //最後の行を分割
                        $num=$word[0]+1;     //最後の行の投稿番号＋１が次の投稿番号
                    
                    } else { 
                        $num=1;   //ファイルがない場合、投稿番号は１
                    }
                    
                    //ファイルに保存する文字列
                    $str=$num."<>".$name."<>".$comment."<>".$date."<>".$pwd."<>";

                    $fp=fopen($filename,"a");
                    fwrite($fp,$str.PHP_EOL);
                    fclose($fp);
                }
            }
            
            //削除関連処理
            if($del_num && $del_pwd){
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    
                    $fp=fopen($filename,"w+");    //書き込み準備、中身を空に
                    foreach ($lines as $line) {    //配列をループ処理
                        $word=explode("<>",$line);    //行を分割
                        if($del_num!=$word[0]) {    //投稿番号と削除番号が一致しない？
                            if($del_pwd!=$word[5]){
                                fwrite($fp,$line.PHP_EOL);  //行ごとに書き込む
                            }
                        }
                    }
                fclose($fp);
                }
            }
            
            //表示機能
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            foreach ($lines as $line) {
                $word=explode("<>",$line);
                echo $word[0]." ".$word[1]." ".$word[2]." ".$word[3]."<br>";
            }
        ?>
                 



    </body>
</html>
