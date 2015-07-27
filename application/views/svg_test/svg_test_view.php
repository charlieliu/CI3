<div id="body">

    <div>
        <p>矩形 rect</p>
        <ul>
            <li>x = X 座標</li>
            <li>y = Y 座標</li>
            <li>width = 寬度</li>
            <li>height = 高度</li>
        </ul>
        <svg width="100%" height="100" version="1.1">
            <rect x="5" y="5" width="50" height="50" style="fill:blue;stroke:pink;stroke-width:5;fill-opacity:0.1;stroke-opacity:0.9"/>
        </svg>
    </div>

    <div>
        <p>圓形 circle</p>
        <ul>
            <li>中心點預設(0, 0)</li>
            <li>cx = X 座標</li>
            <li>cy = Y 座標</li>
            <li>r = 半徑</li>
        </ul>
        <svg width="100%" height="84" version="1.1">
            <circle cx="42" cy="42" r="40" stroke="black" stroke-width="2" fill="red"/>
        </svg>
    </div>

    <div>
        <p>橢圓 ellipse</p>
        <ul>
            <li>cx = X 座標</li>
            <li>cy = Y 座標</li>
            <li>rx = X 半徑</li>
            <li>ry = Y 半徑</li>
        </ul>
        <svg width="100%" height="84" version="1.1">
            <ellipse cx="102" cy="42" rx="100" ry="40" style="fill:rgb(200,100,50);stroke:rgb(0,0,100);stroke-width:2"/>
        </svg>
    </div>

    <div>
        <p>線條 line</p>
        <ul>
            <li>x1 = x 軸開始</li>
            <li>y1 = y 軸開始</li>
            <li>x2 = x 軸結束</li>
            <li>y2 = y 軸結束</li>
        </ul>
        <svg width="100%" height="54" version="1.1">
            <line x1="0" y1="0" x2="100" y2="50" style="stroke:rgb(99,99,99);stroke-width:2"/>
        </svg>
    </div>

    <div>
        <p>多邊形 polygon</p>
        <ul>
            <li>points 定義每個點座標x,y</li>
        <ul>
        <svg width="100%" height="62" version="1.1">
            <polygon points="0,0 0,20 40,20 20,40 40,40 40,60" style="fill:#cccccc;stroke:#000000;stroke-width:1"/>
        </svg>
        <b>(0,0) (0,20) (40,20) (20,40) (40,40) (40,60)</b>
    </div>

    <div>
        <p>折線 polyline</p>
        <ul>
            <li>points 定義每個點座標x,y</li>
        <ul>
        <svg width="100%" height="64" version="1.1">
            <polyline points="0,0 0,20 40,20 20,40 40,40 40,60" style="fill:white;stroke:red;stroke-width:2"/>
        </svg>
        <b>(0,0) (0,20) (40,20) (20,40) (40,40) (40,60)</b>
    </div>

    <div>
        <p>路徑 path</p>
        <ul>
            <li>M = moveto</li>
            <li>L = lineto</li>
            <li>H = horizontal lineto</li>
            <li>V = vertical lineto</li>
            <li>C = curveto</li>
            <li>S = smooth curveto</li>
            <li>Q = quadratic Belzier curve</li>
            <li>T = smooth quadratic Belzier curveto</li>
            <li>A = elliptical Arc</li>
            <li>Z = closepath</li>
        </ul>
        <svg width="100%" height="114" version="1.1">
            <path d="M44 62
            C44 62 42 62 42 62
            C42 67 44 72 47 72
            C55 72 62 67 62 62
            C62 50 55 42 47 42
            C33 42 22 50 22 62
            C22 78 33 92 47 92
            C66 92 82 78 82 62
            C82 39 66 22 47 22
            C22 22 2 39 2 62
            C2 89 22 112 47 112
            C77 112 102 89 102 62
            C102 28 77 2 47 2
            L102 62 47 112 2 62
            L47 22 82 62 47 92
            L22 62 47 42 62 62
            L47 72 42 62 44 62"
            style="fill:white;stroke:red;stroke-width:2"/>
        </svg>
    </div>

</div>