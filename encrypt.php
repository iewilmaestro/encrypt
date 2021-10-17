<?php

class obfuscate
{
        var $text,$string;
        public function construct()
        {                                                                     #$this->string = self::cleanTxt($string);
        }
        public function strToHex($string)
        {
                $this->text = bin2hex($string);
                $this->text = chunk_split($this->text,2,"\x");
                $this->text = "\x" . substr($this->text,0,-2);
                return $this->text;
        }
        public function genStr($x=10)
        {
                $this->string = "qwertyuiopasdfghjklzxcvbnm";
                $this->output = "";
                for ($i=0; $i < $x; $i++) {
                        $this->output .= $this->string[rand(0,strlen($this->string) - 1)];
                }
                return $this->output;
        }
        public function cleanTxt($string)
        {
                return str_replace(['<?php','?>'], "", $string);
        }
        public function execute($string)
        {
                $this->content = "";
                $this->content = self::cleanTxt($string);
                $this->content = self::encode($this->content);
                $this->content = self::strToHex($this->content);
                $this->var1 = self::genStr(10);
                $this->var2 = self::genStr(15);
                $this->output = '$'.$this->var1.'= base64_decode("\x59\x6d\x46\x7a\x5a\x54\x59\x30\x58\x32\x52\x6c\x59\x32\x39\x6b\x5a\x51\x3d\x3d");$'.$this->var2.'=base64_decode("\x63\x33\x52\x79\x58\x33\x4a\x76\x64\x44\x45\x7a");@eval($'.$this->var1.'($'.$this->var2.'("'.$this->content.'")));';
                return $this->output;
        }
        public function encode($string)
        {
                $this->text = str_rot13(base64_encode($string));
                return $this->text;
        }
}
final class iewil extends obfuscate
{
        public function construct()
        {
                echo " Simple Obfusate By iewil\n";
                echo " Input File : ";
                $file = trim(fgets(STDIN));
                self::_run($file);
        }
        public function _run($file)
        {
                $file = file_get_contents($file) or die(self::msg("File Not FOund"));
                $data = self::execute($file);
                $output = '<?php /*Obfusate By iewil*/ '.PHP_EOL.$data.' ?>';
                self::msg("Success Obfusate , Genereting FIle....");
                $files = self::genStr(15).".php";
                self::save($files,$output);
                self::msg("File Name : {$files}");
        }
        public function save($file,$data){
                $fp = @fopen($file, "a");
                @fwrite($fp, $data);
                @fclose($fp);
        }
        public function msg($data){
                echo " [".date("h:i:s")."] {$data}\n";
        }
}
(new iewil);
