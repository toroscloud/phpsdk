<h1 class="code-line" data-line-start=0 data-line-end=1 ><a id="TOROS_CLOUD_0"></a>TOROS CLOUD</h1>
<p class="has-line-data" data-line-start="2" data-line-end="3"><a href="https://toros.com.br"><img src="https://www.toros.com.br/assets/images/toros2.png" alt="N|Solid"></a></p>
<p class="has-line-data" data-line-start="4" data-line-end="5">We are the first Brazilian cloud company to offer blockchain file storage</p>
<h1 class="code-line" data-line-start=6 data-line-end=7 ><a id="Exemple_PHP_6"></a>Exemple PHP</h1>
<pre><code class="has-line-data" data-line-start="9" data-line-end="54" class="language-sh">&lt;?php

require_once  <span class="hljs-string">'vendor/autoload.php'</span>;

use Toros\Toros as TOROS;

<span class="hljs-variable">$API_KEY</span>      = <span class="hljs-string">""</span>;
<span class="hljs-variable">$API_SECRET</span>   = <span class="hljs-string">""</span>;

<span class="hljs-variable">$api</span> = new TOROS(<span class="hljs-variable">$API_KEY</span>,<span class="hljs-variable">$API_SECRET</span>);

//New bucket
<span class="hljs-variable">$return</span> = <span class="hljs-variable">$api</span>-&gt;newBucket(<span class="hljs-string">'namebucket'</span>);
<span class="hljs-built_in">print</span>_r(<span class="hljs-variable">$return</span>);

//Delete bucket
<span class="hljs-variable">$return</span> = <span class="hljs-variable">$api</span>-&gt;delBucket(<span class="hljs-string">'namebucket'</span>);
<span class="hljs-built_in">print</span>_r(<span class="hljs-variable">$return</span>);

//Upload file
<span class="hljs-variable">$name_bucket</span> = <span class="hljs-string">'namebucket'</span>;
<span class="hljs-variable">$file_origin</span> = <span class="hljs-string">'origin_file.png'</span>;
<span class="hljs-variable">$file_destiny</span> = <span class="hljs-string">'directory/destiny_file.png'</span>;
<span class="hljs-variable">$return</span> = <span class="hljs-variable">$api</span>-&gt;upload(<span class="hljs-variable">$name_bucket</span>, <span class="hljs-variable">$file_origin</span>, <span class="hljs-variable">$file_destiny</span>);
<span class="hljs-built_in">print</span>_r(<span class="hljs-variable">$return</span>);

//Delete file
<span class="hljs-variable">$name_bucket</span> = <span class="hljs-string">'namebucket'</span>;
<span class="hljs-variable">$file_destiny</span> = <span class="hljs-string">'directory/destiny_file.png'</span>;
<span class="hljs-variable">$return</span> = <span class="hljs-variable">$api</span>-&gt;delete(<span class="hljs-variable">$name_bucket</span>, <span class="hljs-variable">$file_destiny</span>);
<span class="hljs-built_in">print</span>_r(<span class="hljs-variable">$return</span>);

//Get list file
<span class="hljs-variable">$name_bucket</span> = <span class="hljs-string">'namebucket'</span>;
<span class="hljs-variable">$file_destiny</span> = <span class="hljs-string">'directory'</span>;
<span class="hljs-variable">$return</span> = <span class="hljs-variable">$api</span>-&gt;list(<span class="hljs-variable">$name_bucket</span>, <span class="hljs-variable">$file_destiny</span>);
<span class="hljs-built_in">print</span>_r(<span class="hljs-variable">$return</span>);

//Download file
<span class="hljs-variable">$name_bucket</span> = <span class="hljs-string">'namebucket'</span>;
<span class="hljs-variable">$file</span> = <span class="hljs-string">'directory/destiny_file.png'</span>;
<span class="hljs-variable">$file_local</span> = <span class="hljs-string">'/home/user/file/vaiiii2.png'</span>;
<span class="hljs-variable">$return</span> = <span class="hljs-variable">$api</span>-&gt;download(<span class="hljs-variable">$name_bucket</span>, <span class="hljs-variable">$file</span>,<span class="hljs-variable">$file_local</span>);

</code></pre>
<p class="has-line-data" data-line-start="54" data-line-end="55"><a href="http://www.toros.com.br">www.toros.com.br</a></p>
