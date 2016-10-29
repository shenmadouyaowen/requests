# requests
销帮帮接口调用类

使用类库 https://github.com/rmccue/Requests 
如果是从 https://github.com/rmccue/Requests 重新下载的类库 ,在 Requests.php 添加一下函数

/** 快速查找目录、文件 */

	public static function find($dir)
	{
	    if(!is_dir($dir)) # 如果$dir变量不是一个目录，直接返回false
	        return false;
	        $dirs[] = '';     # 用于记录目录
	        $files = array(); # 用于记录文件
	        while(list($k,$path)=each($dirs))
	        {
	            $absDirPath = "$dir/$path";     # 当前要遍历的目录的绝对路径
	            $handle = opendir($absDirPath); # 打开目录句柄
	            readdir($handle);               # 先调用两次 readdir() 过滤 . 和 ..
	            readdir($handle);               # 避免在 while 循环中 if 判断
	            while(false !== $item=readdir($handle))
	            {
	                $relPath = "$path/$item";   # 子项目相对路径
	                $absPath = "$dir/$relPath"; # 子项目绝对路径
	                if(!is_dir($absPath)){        # 如果是一个目录，则存入到数组 $dirs
	                   if (file_exists($absPath)) {
		                  	require_once($absPath);
		               }
	                }                        # 否则是一个文件，则存入到数组 $files
	                       
	            }
	            closedir($handle); # 关闭目录句柄
	        }
	}
