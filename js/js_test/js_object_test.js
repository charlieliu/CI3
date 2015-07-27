$(function(){
    //最上層類別
    function Grandfather() {
        this.birthday = {
            year: null,
            month: null,
            day: null
        };
        this.setBirthdayYear(1889);
    }

    //屬性
    Grandfather.prototype.birthday = {
        year: null,
        month: null,
        day: null
    };

    //方法
    Grandfather.prototype.setBirthdayYear = function (year)
    {
        this.birthday.year = year;
    };

    //上層類別
    function Father() {
        Grandfather.call(this);
        this.setBirthdayYear(1915);
    }

    //Father繼承Grandfather
    Father.prototype = new Grandfather();

    //子類別之一
    function Son() {
        Father.call(this);
        this.setBirthdayYear(1943);
    }

    //Son繼承Father
    Son.prototype = new Father();

    //子類別之二
    function Daughter() {
        Father.call(this);
        this.setBirthdayYear(1945);
    }

    //Daughter繼承Father
    Daughter.prototype = new Father();

    //輸出檢驗
    var son = new Son();
    var daughter = new Daughter();
    var father = new Father();
    var grandfather = new Grandfather();

    $('#Grandfather').html(typeof(Grandfather)+'/'+Grandfather);
    $('#grandfather').html(typeof(grandfather)+'/'+grandfather.birthday.year);
    $('#father').html(typeof(father)+'/'+father.birthday.year);
    $('#son').html(typeof(son)+'/'+son.birthday.year);
    $('#daughter').html(typeof(daughter)+'/'+daughter.birthday.year);
});