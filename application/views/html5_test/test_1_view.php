<div id="body">
    <p>{current_page}/{current_fun}</p>

    <div class="content_block mg1em padding1em">
        <video id="Video1" width="320" controls>
            //  Replace these with your own video files.
            <source src="<?=base_url()?>demo/demo.mp4" type="video/mp4" />
            <source src="<?=base_url()?>demo/demo.ogv" type="video/ogg" />
            HTML5 Video is required for this example.
            <a href="demo.mp4">Download the video</a> file.
        </video>

        <div id="buttonbar">
            <button class="act_btn" id="restart" onclick="restart();">[]</button>
            <button class="act_btn" id="rew" onclick="skip(-1)">&lt;&lt;</button>
            <button class="act_btn" id="play" onclick="vidplay()">&gt;</button>
            <button class="act_btn" id="fastFwd" onclick="skip(1)">&gt;&gt;</button>
        </div>
    </div>

    <div class="content_block mg1em padding1em">
        &lt;audio controls&gt;<br>
        {space_4}&lt;source src="demo/horse.ogg" type="audio/ogg"&gt;<br>
        {space_4}&lt;source src="demo/horse.mp3" type="audio/mpeg"&gt;<br>
        {space_4}Your browser does not support the audio element.<br>
        &lt;/audio&gt;<br>
        <audio controls>
            <source src="<?=base_url()?>demo/horse.ogg" type="audio/ogg">
            <source src="<?=base_url()?>demo/horse.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>

    <div class="content_block mg1em padding1em">
        &lt;video controls&gt;<br>
        {space_4}&lt;source src="demo/movie.mp4" type="video/mp4"&gt;<br>
        {space_4}&lt;source src="demo/movie.ogg" type="video/ogg"&gt;<br>
        {space_4}Your browser does not support the video tag.<br>
        &lt;/video&gt;<br>
        <video controls>
            <source src="<?=base_url()?>demo/movie.mp4" type="video/mp4">
            <source src="<?=base_url()?>demo/movie.ogg" type="video/ogg">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="content_block mg1em padding1em">
        &lt;iframe src="http://www.youtube.com/embed/P2QrLuMq2Ow?autoplay=1&loop=1"&gt;&lt;/iframe&gt;<br>
        <iframe src="http://www.youtube.com/v/P2QrLuMq2Ow?autoplay=1&loop=1"></iframe>
    </div>

    <div class="content_block mg1em padding1em">
        <h3>The&nbsp;&lt;object&gt;&nbsp;Element</h3>
        <ul>
            <li>The&nbsp;&lt;object&gt;&nbsp;element is supported by all browsers.</li>
            <li>The&nbsp;&lt;object&gt;&nbsp;element defines an embedded object within an HTML document.</li>
            <li>It is used to embed plug-ins (like Java applets, PDF readers, Flash Players) in web pages.</li>
        </ul>
        &lt;object data="http://www.youtube.com/v/K_xTet06SUo"&gt;&lt;/object&gt;<br>
        <object data="http://www.youtube.com/v/K_xTet06SUo"></object>
    </div>

    <div class="content_block mg1em padding1em">
        <h3>The&nbsp;&lt;embed&gt;&nbsp;Element</h3>
        <ul>
            <li>The&nbsp;&lt;embed&gt;&nbsp;element is supported in all major browsers.</li>
            <li>The&nbsp;&lt;embed&gt;&nbsp;element also defines an embedded object within an HTML document.</li>
            <li>Web browsers have supported the&nbsp;&lt;embed&gt;&nbsp;element for a long time. However, it has not been a part of the HTML specification before HTML5. The element will validate in an HTML5 page, but not in an HTML 4 page.</li>
        </ul>
        &lt;embed src="http://www.youtube.com/embed/Y5zj3dwNxJw"&gt;<br>
        <embed src="http://www.youtube.com/embed/Y5zj3dwNxJw">
    </div>
</div>