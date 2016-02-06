Currently only supports English, Simplified Chinese, and Traditional Chinese.

**Notes**:
 - Responsive design is now implemented.
 - Uses PHP / MySQL / HTML5 / CSS3 / jQuery / jQueryUI / Javascript
 - Now has language-changing jQuery code 
 - Now supports cookies for saving language data.
 - Now supports Traditional Chinese
 - Currently doesn't have Captcha.
 - Doesn't currently have pagination
 - You ***must*** have a database generated by Bible-Generator before this will be of any use to you.
 - You ***must*** set `$servername`, `$databasename`, `$username`, and `$password` in `classes/GlobalVariables.php` in order for this to work.
 - Supports Chinese dashes, `——` (double),  `—` (single), and English dashes (-). 
  - This is to maintain compatibility with Chinese Input Methods, which generally force two dashes when using the shift+dash button.
 - Some verses are *missing* in Chinese. 
  - **This does not mean they've been removed**: rather, the removed verse and the previous verse have been combined. This is because, apparently, some of these verses do not make sense on their own, and must be combined into a single verse. 
  - As far as I know, the words are still intact and have their same meaning. 
  - When this occurs, the missing verse is shown as, "**見上節**" in Traditional Chinese, and as " " (empty space) in Simplified Chinese. 
  - This feature also helps to maintain backwards compability with English searches and processing, without needing lots of extra code.
- You do not need to change your language to search either English or Chinese. You may perform a search using either language, and it will be recognized.


## English Example Queries: ##

**Book searches now have default values. You may either click "Search," or submit the form in some other way and, depending on the language used, it will return some example queries.**

 - **Book Searches**
  - Genesis 
  - Genesis 1:1
  - Genesis 1-2
  - Genesis 1:1-3
 - **Keyword searches**
  - love 
  - oppress
  - hate
 
**Please note that keywords are restricted by the language of KJV. You may not find what you're looking for by using the common English words and terms of present times.**
 
## Simplified Chinese Example Queries: ##

 - **Book Searches**
  - 创世记 
  - 创世记 1:1
  - 创世记 1-2
  - 创世记 1:1-3
 - **Keyword searches**
  - Not yet implemented

## Traditional Chinese Example Queries: ##
 - **Book Searches**
  - 創世記 
  - 創世記 1:1
  - 創世記 1-2
  - 創世記 1:1-3
 - **Keyword searches**
  - Not yet implemented

## Full Simplified Chinese Book List (Chronological Order) ##

 - 创世记
 - 出埃及
 - 利未记
 - 民数记
 - 申命记
 - 约书亚记
 - 士师记
 - 路得记
 - 撒母耳记上
 - 撒母耳记下
 - 列王纪上
 - 列王纪下
 - 历代志上
 - 历代志下
 - 以斯拉记
 - 尼希米记
 - 以斯帖记
 - 约伯记
 - 诗篇
 - 箴言
 - 传道书
 - 雅歌
 - 以赛亚书
 - 耶利米书
 - 耶利米哀歌
 - 以西结书
 - 但以理书
 - 何西阿书
 - 约珥书
 - 阿摩司书
 - 俄巴底亚书
 - 约拿书
 - 弥迦书
 - 那鸿书
 - 哈巴谷书
 - 西番雅书
 - 哈该书
 - 撒迦利亚书
 - 玛拉基书
 - 马太福音
 - 马可福音
 - 路加福音
 - 约翰福音
 - 使徒行传
 - 罗马书
 - 哥林多前书
 - 哥林多后书
 - 加拉太书
 - 以弗所书
 - 腓立比书
 - 歌罗西书
 - 帖撒罗尼迦前书
 - 帖撒罗尼迦后书
 - 提摩太前书
 - 提摩太后书
 - 提多书
 - 腓利门书
 - 希伯来书
 - 雅各书
 - 彼得前书
 - 彼得后书
 - 约翰一书
 - 约翰二书
 - 约翰三书
 - 犹大书
 - 启示录

## Full Traditional Chinese Book List (Chronological Order) ##

 - 創世記
 - 出埃及
 - 利未記
 - 民數記
 - 申命記
 - 約書亞記
 - 士師記
 - 路得記
 - 撒母耳記上
 - 撒母耳記下
 - 列王紀上
 - 列王紀下
 - 歷代誌上
 - 歷代誌下
 - 以斯拉記
 - 尼希米記
 - 以斯帖記
 - 約伯記
 - 詩篇
 - 箴言
 - 傳道書
 - 雅歌
 - 以賽亞書
 - 耶利米書
 - 耶利米哀歌
 - 以西結書
 - 但以理書
 - 何西阿書
 - 約珥書
 - 阿摩司書
 - 俄巴底亞書
 - 約拿書
 - 彌迦書
 - 那鴻書
 - 哈巴谷書
 - 西番雅書
 - 哈該書
 - 撒迦利亞書
 - 瑪拉基書
 - 馬太福音
 - 馬可福音
 - 路加福音
 - 約翰福音
 - 使徒行傳
 - 羅馬書
 - 哥林多前書
 - 哥林多後書
 - 加拉太書
 - 以弗所書
 - 腓立比書
 - 歌羅西書
 - 帖撒羅尼迦前書
 - 帖撒羅尼迦後書
 - 提摩太前書
 - 提摩太后書
 - 提多書
 - 腓利門書
 - 希伯來書
 - 雅各書
 - 彼得前書
 - 彼得後書
 - 約翰一書
 - 約翰二書
 - 約翰三書
 - 猶大書
 - 啟示錄
