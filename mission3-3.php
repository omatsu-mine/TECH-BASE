<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission3-3</title>
    </head>
    <body>
        <form method="post">
            <input type="name" name="name" placeholder="名前"><br>
            <input type="comment" name="comment" placeholder="コメント">
            <input type="submit" name="submit"><br><br>
            <input type="number" name="number" placeholder="削除対象番号">
            <input type="submit" name="delete" value="削除"><br><br>
            </form>

        <?php
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $number=$_POST["number"];
            $date=date("Y/m/d H:i:s");
            $filename="mission_3-3.txt";
            
            //投稿番号を決定する処理
            if (file_exists($filename)){
                //ファイルを読み込んで配列変数に代入
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    $last=count($lines);     //行数をカウント
                    $lastline=$lines[$last-1];    //最後の行の要素数
                    $word=explode("<>",$lastline);    //最後の行を分割
                    $num=$word[0]+1;     //最後の行の投稿番号＋１が次の投稿番号
            } else { 
                $num=1;  //ファイルがない場合、投稿番号は１
            }

            //ファイルに保存する文字列
            $str=$num."<>".$name."<>".$comment."<>".$date;

            //ファイルに保存する処理
            if($name && $comment){
                $fp=fopen($filename,"a");
                fwrite($fp,$str.PHP_EOL);
                fclose($fp);
            }
            
            //削除関連処理
            if($number){
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    $fp=fopen($filename,"w+");    //書き込み準備、中身を空に
                    foreach ($lines as $line) {    //配列をループ処理
                        $word=explode("<>",$line);    //行を分割
                        if($number!=$word[0]) {    //投稿番号と行番号が一致しない？
                            fwrite($fp,$line.PHP_EOL);  //行ごとに書き込む
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
