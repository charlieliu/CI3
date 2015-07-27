<?php
set_time_limit ( 604800 );
//echo 'LINE : '.__LINE__.'<br>' ;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//echo 'LINE : '.__LINE__.'<br>' ;

class Add_hash_lib extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		ini_set("session.cookie_httponly", 1);
		header("x-frame-options:sammeorigin");
		header('Content-Type: text/html; charset=utf8');
		//echo 'LINE : '.__LINE__.'<br>' ;

		// load parser
		$this->load->library(array('parser','session', 'pub'));
		//echo 'LINE : '.__LINE__.'<br>' ;
		$this->load->helper(array('form', 'url'));
		//echo 'LINE : '.__LINE__.'<br>' ;
		$this->load->model('add_hash_lib_model','',TRUE) ;
		//echo 'LINE : '.__LINE__.'<br>' ;
	}

	public function index()
	{
		if( base_url()!='http://localhost/' && base_url()!='http://127.0.0.1/' )
		{
			exit(base_url());
		}
		/*
		$total = $this->db_count();

		// top 500 pwds + top 500 ios pwds + default john
		if( $total<3953 )
		{
			echo 'After john members = '.$total.'<br>';
			$this->_add_top_500_pwds();
			$total = $this->db_count();
			echo 'Before john members = '.$total.'<br>';
		}

		// 62*62*62*62 = 14776336
		if( $total<14776336 )
		{
			echo 'After loop members = '.$total.'<br>';
			$this->_add_hash_lib(4);
			$total = $this->db_count();
			echo 'Before loop members = '.$total.'<br>';
		}
		*/
		$str = 'lib numbers = '.$this->add_hash_lib_model->get_hash_test_num().'<br><br>' ;
		$arr_seed = array(
			'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
			'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
			'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
			'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l',
			'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L',
			'z', 'x', 'c', 'v', 'b', 'n', 'm',
			'Z', 'X', 'C', 'V', 'B', 'N', 'M',
		);
		foreach ($arr_seed as $key => $value)
		{
			$break1 = $this->add_hash_lib_model->query_hash_test($value.'111',1,1,false) ;
			$break2 = $this->add_hash_lib_model->query_hash_test($value.'ggg',1,1,false) ;
			$break3 = $this->add_hash_lib_model->query_hash_test($value.'MMM',1,1,false) ;
			if( $break1['status']!='100' || $break2['status']!='100'|| $break3['status']!='100' )
			{
				$url = base_url().'add_hash_lib/add_rainbowtable/'.$key.'/mysql' ;
				exit($this->_get_script($str, $url));
			}
		}
	}

	public function add_rainbowtable($seed='', $db_type='mysql')
	{
		if( base_url()!='http://localhost/' && base_url()!='http://127.0.0.1/' )
		{
			exit(base_url());
		}

		$arr_seed = array(
			'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
			'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
			'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
			'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l',
			'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L',
			'z', 'x', 'c', 'v', 'b', 'n', 'm',
			'Z', 'X', 'C', 'V', 'B', 'N', 'M',
		);
		$seed = intval($seed) ;
		if(isset($arr_seed[$seed]) )
		{
			$this->_add_hash_lib(3, array($arr_seed[$seed]), 'default', $db_type);
		}
		header('Location: '.base_url().'add_hash_lib');
		exit();
	}

	/**
	 * @author Charlie Liu <liuchangli0107@gmail.com>
	 */
	private function db_count()
	{
		$total = $this->add_hash_lib_model->get_hash_test_num() ;// for WIN8's apache
		$total = isset($total[0]['total']) ? intval($total[0]['total']) : (isset($total['total']) ? intval($total['total']) : intval($total) ) ;
		return $total ;
	}

	private function _add_hash_lib($level=0,$arr_add='',$seed_type='default',$db_type='')
	{
		// lib
		switch ($seed_type)
		{
			case 'alpha':
				$level_1 = array(
					'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
					'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l',
					'z', 'x', 'c', 'v', 'b', 'n', 'm',
				);
				break;
			case 'ALPHA':
				$level_1 = array(
					'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
					'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L',
					'Z', 'X', 'C', 'V', 'B', 'N', 'M',
				);
				break;
			case 'numbers':
				$level_1 = array(
					'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
				);
				break;
			case 'keyboard':
				$level_1 = array(
					'`','1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=',
					'~','!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+',
					'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', '[', ']', '\\',
					'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', '{', '}', '|',
					'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', ';', "'",
					'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', ':', '"',
					'z', 'x', 'c', 'v', 'b', 'n', 'm',',', '.', '/',' ',
					'Z', 'X', 'C', 'V', 'B', 'N', 'M', '<', '>', '?',
				);
				break;
			default:
				$level_1 = array(
					'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
					'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
					'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
					'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l',
					'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L',
					'z', 'x', 'c', 'v', 'b', 'n', 'm',
					'Z', 'X', 'C', 'V', 'B', 'N', 'M',
				);
				break;
		};
		//echo 'seed_type = '.$seed_type.'<br>';

		$arr_1 = (is_array($arr_add) && !empty($arr_add) ) ? $arr_add : $level_1;
		$arr_2 = $level_1;

		$loop = intval($level);
		if( $loop==1 )
		{
			if(is_array($arr_add) && !empty($arr_add) )
			{
				$arr_2 = $this->_add_hash_lib_loop($arr_1,$arr_2);
			}
			else
			{
				foreach ( $arr_2 as $arr_2 )
				{
					$this->add_hash_lib_model->query_hash_test($val_2);
				}
			}
		}
		else if( $loop>1 )
		{
			for ($i=0; $i<$loop; $i++)
			{
				$arr_1 = $this->_add_hash_lib_loop($arr_1, $arr_2, 3, $db_type);
			}
			echo 'count($arr_1) = '.count($arr_1).'<br>' ;
		}
	}

	private function _add_hash_lib_loop($arr_1, $arr_2, $min_len=3, $db_type='')
	{
		$min_len = intval($min_len);
		$output = array();
		foreach ( $arr_1 as $val_1 )
		{
			foreach ( $arr_2 as $val_2 )
			{
				$output[] = $val_1.$val_2;
				if( mb_strlen($val_1.$val_2)>$min_len )
				{
					if( $db_type=='mysql' )
					{
						$result = $this->add_hash_lib_model->query_hash_test($val_1.$val_2);
					}
					else if( $db_type=='redis' )
					{
						$result = $this->add_hash_lib_model->add_hash_redis($val_1.$val_2);
					}
					else
					{
						$result = array() ;
					}
					if( !empty($result['status']) && $result['status']=='100' )
					{
						if( isset($result['result']) && is_array($result['result']) )
						{
							foreach ($result['result'] as $key => $value)
							{
								if( empty($value) )
								{
									echo 'LINE : '.__LINE__.'<br>' ;
									print_r($result);
									echo '<br>' ;
									exit($val_1.$val_2);
								}
							}
						}
						else
						{
							//echo $val_1.$val_2.'<br>' ;
						}
					}
					else
					{
						echo 'LINE : '.__LINE__.'<br>' ;
						print_r($result);
						echo '<br>' ;
						exit($val_1.$val_2);
					}
				}
			}
		}
		return $output ;
	}

	private function _get_script($str, $url)
	{
		$output = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><!--HTML5-->' ;
		$output .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">' ;
		$output .= '<meta name="title" content="'.__CLASS__.'">' ;
		$output .= '<meta name="description" content="'.__CLASS__.'">' ;
		$output .= '<meta property="og:image" content="'.base_url().'images/joba.jpg">' ;
		$output .= '<meta http-equiv="X-Content-Type-Options" content="nosniff">' ;
		$output .= '<meta http-equiv="x-frame-options" content="SAMEORIGIN">' ;
		$output .= '<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->' ;
		$output .= '<title>'.__CLASS__.'</title></head><body>'.$str.'<br>'.$url ;
		$output .= '<noscript>Your browser does not support JavaScript!</noscript>' ;
		$output .= '<script type="text/javascript">document.location.href="'.$url.'";</script></body></html>' ;
		return $output ;
	}

	private function _add_top_500_pwds()
	{
		$toppwds = array(
			'123456','pa#sword','12345678','1234','p#ssy','12345','dragon','qwerty','696969','mustang','password','passy',
			'letmein','baseball','master','michael','football','shadow','monkey','abc123','pa#s','f#ckme','pass',
			'6969','jordan','harley','ranger','iwantu','jennifer','hunter','f#ck','2000','test','fuck',
			'batman','trustno1','thomas','tigger','robert','access','love','buster','1234567','soccer',
			'hockey','killer','george','sexy','andrew','charlie','superman','a#shole','f#ckyou','dallas','fuckyou',
			'jessica','panties','pepper','1111','austin','william','daniel','golfer','summer','heather',
			'hammer','yankees','joshua','maggie','biteme','enter','ashley','thunder','cowboy','silver',
			'richard','f#cker','orange','merlin','michelle','corvette','bigdog','cheese','matthew','121212','fucker',
			'patrick','martin','freedom','ginger','bl#wjob','nicole','sparky','yellow','camaro','secret',
			'dick','falcon','taylor','111111','131313','123123','bitch','hello','scooter','please',
			'porsche','guitar','chelsea','black','diamond','nascar','jackson','cameron','654321','computer',
			'amanda','wizard','xxxxxxxx','money','phoenix','mickey','bailey','knight','iceman','tigers',
			'purple','andrea','horny','dakota','aaaaaa','player','sunshine','morgan','starwars','boomer',
			'cowboys','edward','charles','girls','booboo','coffee','xxxxxx','bulldog','ncc1701','rabbit',
			'peanut','john','johnny','gandalf','spanky','winter','brandy','compaq','carlos','tennis',
			'james','mike','brandon','fender','anthony','blowme','ferrari','cookie','chicken','maverick',
			'chicago','joseph','diablo','sexsex','hardcore','666666','willie','welcome','chris','panther',
			'yamaha','justin','banana','driver','marine','angels','fishing','david','maddog','hooters',
			'wilson','butthead','dennis','f#cking','captain','bigdick','chester','smokey','xavier','steven','fucking',
			'viking','snoopy','blue','eagles','winner','samantha','house','miller','flower','jack',
			'firebird','butter','united','turtle','steelers','tiffany','zxcvbn','tomcat','golf','bond007',
			'bear','tiger','doctor','gateway','gators','angel','junior','thx1138','porno','badboy',
			'debbie','spider','melissa','booger','1212','flyers','fish','porn','matrix','teens',
			'scooby','jason','walter','c#mshot','boston','braves','yankee','lover','barney','victor',
			'tucker','princess','mercedes','5150','doggie','zzzzzz','gunner','horney','bubba','2112',
			'fred','johnson','xxxxx','tits','member','boobs','donald','bigdaddy','bronco','penis',
			'voyager','rangers','birdie','trouble','white','topgun','bigtits','bitches','green','super',
			'qazwsx','magic','lakers','rachel','slayer','scott','2222','asdf','video','london',
			'7777','marlboro','srinivas','internet','action','carter','jasper','monster','teresa','jeremy',
			'11111111','bill','crystal','peter','p#ssies','c#ck','beer','rocket','theman','oliver','cock',
			'prince','beach','amateur','7777777','muffin','redsox','star','testing','shannon','murphy',
			'frank','hannah','dave','eagle1','11111','mother','nathan','raiders','steve',
			'forever','angela','viper','ou812','jake','lovers','suckit','gregory','buddy','whatever',
			'young','nicholas','lucky','helpme','jackie','monica','midnight','college','baby','c#nt','cunt',
			'brian','mark','startrek','sierra','leather','232323','4444','beavis','bigc#ck','happy','bigcock',
			'sophie','ladies','naughty','giants','booty','blonde','f#cked','golden','0000','fire','fucked',
			'sandra','pookie','packers','einstein','dolphins','0','chevy','winston','warrior','sammy',
			'slut','8675309','zxcvbnm','nipples','power','victoria','asdfgh','vagina','toyota','travis',
			'hotdog','paris','rock','xxxx','extreme','redskins','erotic','dirty','ford','freddy',
			'arsenal','access14','wolf','nipple','iloveyou','alex','florida','eric','legend','movie',
			'success','rosebud','jaguar','great','cool','cooper','1313','scorpio','mountain','madison',
			'987654','brazil','lauren','japan','naked','squirt','stars','apple','alexis','aaaa',
			'bonnie','peaches','jasmine','kevin','matt','qwertyui','danielle','beaver','4321','4128',
			'runner','swimming','dolphin','gordon','casper','stupid','shit','saturn','gemini','apples',
			'august','3333','canada','blazer','c#mming','hunting','kitty','rainbow','112233','arthur',
			'cream','calvin','shaved','surfer','samson','kelly','paul','mine','king','racing','5555',
			'eagle','hentai','newyork','little','redwings','smith','sticky','cocacola','animal','broncos',
			'private','skippy','marvin','blondes','enjoy','girl','apollo','parker','qwert','time',
			'sydney','women','voodoo','magnum','juice','abgrtyu','777777','dreams','maxwell','music',
			'rush2112','russia','scorpion','rebecca','tester','mistress','phantom','billy','6666','albert',
			'Password1','Destiny1','Pa$$w0rd','Vanessa1','August12','Fuckoff1','Password11',' Kennedy1','Jordan12','Princess15',
			'Princess1','Brianna1','Forever1','Steelers1','z,iyd86I','Freddie1','Password1!',' Jesusis#1','Jordan01','Princess08',
			'P@ssw0rd','Trustno1','iydgTvmujl6f','Slipknot1','l6fkiy9oN','Forever21','November15',' Jehovah1','Jesus143','PoohBear1',
			'Passw0rd','1qazZAQ!','Zachary1','Princess13',' Sweetie1','Death666','Music123','Isabelle1','Jessica7','Peanut11',
			'Michael1','Precious1','Yankees1','Princess12',' November1','Chopper1','Monkeys1','Hawaii50','Internet1','Peanut01',
			'Blink182','Freedom1','Stephen1','Midnight1','Love4ever','Arianna1','Matthew2','Grandma1','Goddess1','Password7',
			'!QAZ2wsx','Christian1',' Shannon1','Marines1','Ireland1','Allison1','Marie123','Godislove1',' Friends2','Password21',
			'Charlie1','Brooklyn1','John3:16','M1chelle','Iloveme2','Yankees2','Madonna1','Giggles1','Falcons7','Passw0rd1',
			'Anthony1','!QAZxsw2','Gerrard8','Lampard8','Christine1',' TrustNo1','Kristen1','Friday13','Derrick1','October22',
			'1qaz!QAZ','Password2','Fuckyou2','Jesus123','Buttons1','Tiger123','Kimberly1','Formula1','December21',' October13',
			'Brandon1','Football1','ZAQ!1qaz','Frankie1','Babyboy1','Summer05','Justin23','England1','Daisy123','November16',
			'Jordan23','ABCabc123','Pebbles1','Elizabeth2',' Angel101','September1',' Justin11','Cutiepie1','Colombia1','Montana1',
			'1qaz@WSX','Samantha1','Monster1','Douglas1','Vincent1','Sebastian1',' Jesus4me','Cricket1','Clayton1','Michael2',
			'Jessica1','Charmed1','Chicken1','Devil666','Spartan117',' Sabrina1','Jeremiah1','Catherine1',' Cheyenne1','Michael07',
			'Jasmine1','Trinity1','zaq1!QAZ','Christina1',' Soccer12','Princess07',' Jennifer2','Brownie1','Brittney1','Makayla1',
			'Michelle1','Chocolate1',' Spencer1','Bradley1','Princess2','Popcorn1','Jazmine1','Boricua1','Blink-182','Madison01',
			'Diamond1','America1','Savannah1','zaq1@WSX','Penguin1','Pokemon1','FuckYou2','Beckham7','August22','Lucky123',
			'Babygirl1','Password01',' Jesusis1','Tigger01','Password5','Omarion1','Colorado1','Awesome1','Asshole1','Longhorns1',
			'Iloveyou2','Natalie1','Jeffrey1','Summer08','Password3','Nursing1','Christmas1',' Annabelle1',' Ashley12','Kathryn1',
			'Matthew1','Superman1','Houston1','Princess21',' Panthers1','Miranda1','Bella123','Anderson1','Arsenal12','Katelyn1',
			'Rangers1','Scooter1','Florida1','Playboy1','Nirvana1','Melanie1','Bailey12','Alabama1','Addison1','Justin21',
			'Pa55word','Mustang1','Crystal1','October1','Nicole12','Maxwell1','August20','1941.Salembbb.41','Abcd1234','Jesus1st',
			'Iverson3','Brittany1','Tristan1','Katrina1','Nichole1','Lindsay1','3edc#EDC','123qweASD','@WSX2wsx','January29',
			'Sunshine1','Angel123','Thunder1','Iloveme1','Molly123','Joshua01','2wsx@WSX','abcABC123','!Qaz2wsx','ILoveYou2',
			'Madison1','Jonathan1','Thumper1','Chris123','Metallica1',' Hollywood1',' 12qw!@QW','Twilight1','zaq1ZAQ!','Hunter01',
			'William1','Friends1','Special1','Chicago1','Mercedes1','Hershey1','#EDC4rfv','Thirteen13',' ZAQ!xsw2','Honey123',
			'Elizabeth1',' Courtney1','Pr1ncess','Charlotte1',' Mackenzie1',' Hello123','Winter06','Taylor13','Whitney1','Holiday1',
			'Password123',' Aaliyah1','Password12',' Broncos1','Kenneth1','Gordon24','Welcome123',' Superstar1',' Welcome2','Harry123',
			'Liverpool1',' Rebecca1','Justice1','BabyGirl1','Jackson5','Gateway1','Unicorn1','Summer99','Vampire1','Falcons1',
			'Cameron1','Timothy1','Cowboys1','Abigail1','Genesis1','Garrett1','Tigger12','Soccer14','Valerie1','December1',
			'Butterfly1',' Scotland1','Charles1','Tinkerbell1',' Diamonds1','David123','Soccer13','Robert01','Titanic1','Dan1elle',
			'Beautiful1',' Raymond1','Blondie1','Rockstar1','Buttercup1',' Daniela1','Senior06','Prototype1',' Tigger123','Dallas22',
			'!QAZ1qaz','Inuyasha1','Softball1','RockYou1','Brandon7','Butterfly7',' Scrappy1','Princess5','Teddybear1',' College1',
			'Patrick1','Tiffany1','Orlando1','Michelle2','Whatever1','Buddy123','Scorpio1','Princess24',' Tbfkiy9oN','Classof08',
			'Welcome1','Pa55w0rd','Greenday1','Georgia1','TheSims2','Brandon2','Santana1','Pr1nc3ss','Sweetpea1','Chelsea123',
			'Iloveyou1','Nicholas1','Dominic1','Computer1','Summer06','Bethany1','Rocky123','Phantom1','Start123','Chargers1',
			'Bubbles1','Melissa1','!QAZzaq1','Breanna1','Starwars1','Austin316','Ricardo1','Patricia1','Soccer17','Cassandra1',
			'Chelsea1','Isabella1','abc123ABC','Babygurl1','Spiderman1',' Atlanta1','Princess123',' Password13',' Smokey01','Carolina1',
			'ZAQ!2wsx','Summer07','Snickers1','Trinity3','Soccer11','Angelina1','Password9','Passion1','Shopping1','Candy123',
			'Blessed1','Rainbow1','Patches1','Pumpkin1','Skittles1','Alexandra1',' Password4','P4ssword','Serenity1','Brayden1',
			'Richard1','Poohbear1','P@$$w0rd','Princess7','Princess01',' Airforce1','P@55w0rd','Nathan06','Senior07','Bigdaddy1',
			'Danielle1','Peaches1','Natasha1','Preston1','Phoenix1','Winston1','Monkey12','Monkey13','Sail2Boat3',' Bentley1',
			'Raiders1','Gabriel1','Myspace1','Newyork1','Pass1234','Veronica1','Michele1','Monkey01','Rusty123','Batista1',
			'Jackson1','Arsenal1','Monique1','Marissa1','Panther1','Vanilla1','Micheal1','Liverpool123','Russell1','Barcelona1',
			'Jesus777','Antonio1','Letmein1','Liberty1','November11',' Trouble1','Michael7','Liverp00l','Redskins1','Australia1',
			'Jennifer1','Victoria1','James123','Lebron23','Lindsey1','Summer01','Michael01','Laura123','Rebelde1','Austin02',
			'Alexander1',' Stephanie1',' Celtic1888',' Jamaica1','Katherine1',' Snowball1','Matthew3','Ladybug1','Princess4','August10',
			'Ronaldo7','Dolphins1','Benjamin1','Fuckyou1','JohnCena1','Rockyou1','Marshall1','Kristin1','Princess23',' August08',
			'Heather1','ABC123abc','Baseball1','Chester1','January1','Qwerty123','Loveyou2','Kendall1','Princess19',' Arsenal123',
			'Dolphin1','Spongebob1',' 1qazXSW@','Braxton1','Gangsta1','Pickles1','Lakers24','Justin01','Princess18',' Anthony11',
			'123456','12345','password','password1','123456789','12345678','1234567890','abc123','computer','tigger','1234',
			'qwerty','money','carmen','mickey','secret','summer','internet','a1b2c3','123','service','','canada','hello','ranger',
			'shadow','baseball','donald','harley','hockey','letmein','maggie','mike','mustang','snoopy','buster','dragon','jordan',
			'michael','michelle','mindy','patrick','123abc','andrew','bear','calvin','changeme','diamond','fuckme','fuckyou',
			'matthew','miller','tiger','trustno1','alex','apple','avalon','brandy','chelsea','coffee','falcon','freedom','gandalf',
			'green','helpme','linda','magic','merlin','newyork','soccer','thomas','wizard','asdfgh','bandit','batman','boris',
			'butthead','dorothy','eeyore','fishing','football','george','happy','iloveyou','jennifer','jonathan','love','marina',
			'master','missy','monday','monkey','natasha','ncc1701','pamela','pepper','piglet','poohbear','pookie','rabbit','rachel',
			'rocket','rose','smile','sparky','spring','steven','success','sunshine','victoria','whatever','zapata','8675309','amanda',
			'andy','angel','august','barney','biteme','boomer','brian','casey','cowboy','delta','doctor','fisher','island','john','joshua',
			'karen','marley','orange','please','rascal','richard','sarah','scooter','shalom','silver','skippy','stanley','taylor','welcome',
			'zephyr','111111','aaaaaa','access','albert','alexander','andrea','anna','anthony','asdfjkl;','ashley','basketball','beavis',
			'black','bob','booboo','bradley','brandon','buddy','caitlin','camaro','charlie','chicken','chris','cindy','cricket','dakota',
			'dallas','daniel','david','debbie','dolphin','elephant','emily','friend','fucker','ginger','goodluck','hammer','heather',
			'iceman','jason','jessica','jesus','joseph','jupiter','justin','kevin','knight','lacrosse','lakers','lizard','madison',
			'mary','mother','muffin','murphy','nirvana','paris','pentium','phoenix','picture','rainbow','sandy','saturn','scott',
			'shannon','shithead','skeeter','sophie','special','stephanie','stephen','steve','sweetie','teacher','tennis','test',
			'test123','tommy','topgun','tristan','wally','william','wilson','1q2w3e','654321','666666','a12345','a1b2c3d4','alpha',
			'amber','angela','angie','archie','asdf','blazer','bond007','booger','charles','christin','claire','control','danny',
			'david1','dennis','digital','disney','edward','elvis','felix','flipper','franklin','frodo','honda','horses','hunter',
			'indigo','james','jasper','jeremy','julian','kelsey','killer','lauren','marie','maryjane','matrix','maverick','mayday',
			'mercury','mitchell','morgan','mountain','niners','nothing','oliver','peace','peanut','pearljam','phantom','popcorn',
			'princess','psycho','pumpkin','purple','randy','rebecca','reddog','robert','rocky','roses','salmon','samson','sharon',
			'sierra','smokey','startrek','steelers','stimpy','sunflower','superman','support','sydney','techno','walter','willie',
			'willow','winner','ziggy','zxcvbnm','alaska','alexis','alice','animal','apples','barbara','benjamin','billy','blue',
			'bluebird','bobby','bonnie','bubba','camera','chocolate','clark','claudia','cocacola','compton','connect','cookie',
			'cruise','douglas','dreamer','dreams','duckie','eagles','eddie','einstein','enter','explorer','faith','family','ferrari',
			'flamingo','flower','foxtrot','francis','freddy','friday','froggy','giants','gizmo','global','goofy','happy1','hendrix',
			'henry','herman','homer','honey','house','houston','iguana','indiana','insane','inside','irish','ironman','jake','jasmin',
			'jeanne','jerry','joey','justice','katherine','kermit','kitty','koala','larry','leslie','logan','lucky','mark','martin',
			'matt','minnie','misty','mitch','mouse','nancy','nascar','nelson','pantera','parker','penguin','peter','piano','pizza',
			'prince','punkin','pyramid','raymond','robin','roger','rosebud','route66','royal','running','sadie','sasha','security',
			'sheena','sheila','skiing','snapple','snowball','sparrow','spencer','spike','star','stealth','student','sunny','sylvia',
			'tamara','taurus','teresa','theresa','thunderbird','tigers','tony','toyota','travel','tuesday','victory','viper1','wesley',
			'whisky','winnie','winter','wolves','xyz123','zorro','123123','1234567','696969','888888','Anthony','Joshua','Matthew','Tigger',
			'aaron','abby','abcdef','adidas','adrian','alfred','arthur','athena','austin','awesome','badger','bamboo','beagle','bears',
			'beatles','beautiful','beaver','benny','bigmac','bingo','bitch','blonde','boogie','boston','brenda','bright','bubba1',
			'bubbles','buffy','button','buttons','cactus','candy','captain','carlos','caroline','carrie','casper','catch22','chance',
			'charity','charlotte','cheese','cheryl','chloe','chris1','clancy','compaq','conrad','cooper','cooter','copper','cosmos',
			'cougar','cracker','crawford','crystal','curtis','cyclone','dance','diablo','dollars','dookie','dumbass','dundee',
			'elizabeth','eric','europe','farmer','firebird','fletcher','fluffy','france','freak1','friends','fuckoff','gabriel',
			'galaxy','gambit','garden','garfield','garnet','genesis','genius','godzilla','golfer','goober','grace','greenday',
			'groovy','grover','guitar','hacker','harry','hazel','hector','herbert','horizon','hornet','howard','icecream','imagine',
			'impala','jack','janice','jasmine','jason1','jeanette','jeffrey','jenifer','jenni','jesus1','jewels','joker','julie','julie1',
			'junior','justin1','kathleen','keith','kelly','kelly1','kennedy','kevin1','knicks','larry1','leonard','lestat','library',
			'lincoln','lionking','london','louise','lucky1','lucy','maddog','margaret','mariposa','marlboro','martin1','marty','master1',
			'mensuck','mercedes','metal','midori','mikey','millie','mirage','molly','monet','money1','monica','monopoly','mookie','moose',
			'moroni','music','naomi','nathan','nguyen','nicholas','nicole','nimrod','october','olive','olivia','online','oscar','oxford',
			'pacific','painter','peaches','penelope','pepsi','petunia','philip','phoenix1','photo','pickle','player','poiuyt','porsche',
			'porter','puppy','python','quality','raquel','raven','remember','robbie','robert1','roman','rugby','runner','russell','ryan',
			'sailing','sailor','samantha','savage','scarlett','school','sean','seven','shadow1','sheba','shelby','shit','shoes','simba',
			'simple','skipper','smiley','snake','snickers','sniper','snoopdog','snowman','sonic','spitfire','sprite','spunky','starwars',
			'station','stella','stingray','storm','stormy','stupid','sunny1','sunrise','surfer','susan','tammy','tango','tanya','teddy1',
			'theboss','theking','thumper','tina','tintin','tomcat','trebor','trevor','tweety','unicorn','valentine','valerie','vanilla',
			'veronica','victor','vincent','viper','warrior','warriors','weasel','wheels','wilbur','winston','wisdom','wombat','xavier',
			'yellow','zeppelin','1111','1212','Andrew','Family','Friends','Michael','Michelle','Snoopy','abcd1234','abcdefg','abigail',
			'account','adam','alex1','alice1','allison','alpine','andre1','andrea1','angel1','anita','annette','antares','apache','apollo',
			'aragorn','arizona','arnold','arsenal','asdfasdf','asdfg','asdfghjk','avenger','baby','babydoll','bailey','banana','barry',
			'basket','batman1','beaner','beast','beatrice','bella','bertha','bigben','bigdog','biggles','bigman','binky','biology',
			'bishop','blondie','bluefish','bobcat','bosco','braves','brazil','bruce','bruno','brutus','buffalo','bulldog','bullet',
			'bullshit','bunny','business','butch','butler','butter','california','carebear','carol','carol1','carole','cassie','castle',
			'catalina','catherine','cccccc','celine','center','champion','chanel','chaos','chelsea1','chester1','chicago','chico',
			'christian','christy','church','cinder','colleen','colorado','columbia','commander','connie','cookies','cooking',
			'corona','cowboys','coyote','craig','creative','cuddles','cuervo','cutie','daddy','daisy','daniel1','danielle','davids',
			'death','denis','derek','design','destiny','diana','diane','dickhead','digger','dodger','donna','dougie','dragonfly',
			'dylan','eagle','eclipse','electric','emerald','etoile','excalibur','express','fender','fiona','fireman','flash','florida',
			'flowers','foster','francesco','francine','francois','frank','french','fuckface','gemini','general','gerald','germany',
			'gilbert','goaway','golden','goldfish','goose','gordon','graham','grant','gregory','gretchen','gunner','hannah','harold',
			'harrison','harvey','hawkeye','heaven','heidi','helen','helena','hithere','hobbit','ibanez','idontknow','integra',
			'ireland','irene','isaac','isabel','jackass','jackie','jackson','jaguar','jamaica','japan','jenny1','jessie','johan',
			'johnny','joker1','jordan23','judith','julia','jumanji','kangaroo','karen1','kathy','keepout','keith1','kenneth','kimberly',
			'kingdom','kitkat','kramer','kristen','laura','laurie','lawrence','lawyer','legend','liberty','light','lindsay','lindsey',
			'lisa','liverpool','lola','lonely','louis','lovely','loveme','lucas','madonna','malcolm','malibu','marathon','marcel',
			'maria1','mariah','mariah1','marilyn','mario','marvin','maurice','maxine','maxwell','me','meggie','melanie','melissa',
			'melody','mexico','michael1','michele','midnight','mike1','miracle','misha','mishka','molly1','monique','montreal',
			'moocow','moore','morris','mouse1','mulder','nautica','nellie','newton','nick','nirvana1','nissan','norman','notebook',
			'ocean','olivier','ollie','oranges','oregon','orion','panda','pandora','panther','passion','patricia','pearl','peewee',
			'pencil','penny','people','percy','person','peter1','petey','picasso','pierre','pinkfloyd','polaris','police','pookie1',
			'poppy','power','predator','preston','q1w2e3','queen','queenie','quentin','ralph','random','rangers','raptor','reality',
			'redrum','remote','reynolds','rhonda','ricardo','ricardo1','ricky','river','roadrunner','robinhood','rocknroll','rocky1',
			'ronald','roxy','ruthie','sabrina','sakura','sally','sampson','samuel','sandra','santa','sapphire','scarlet','scorpio',
			'scott1','scottie','scruffy','seattle','serena','shanti','shark','shogun','simon','singer','skull','skywalker','slacker',
			'smashing','smiles','snowflake','snuffy','soccer1','soleil','sonny','spanky','speedy','spider','spooky','stacey','star69',
			'start','steven1','stinky','strawberry','stuart','sugar','sundance','superfly','suzanne','suzuki','swimmer','swimming',
			'system','taffy','tarzan','teddy','teddybear','terry','theatre','thunder','thursday','tinker','tootsie','tornado','tracy',
			'tricia','trident','trojan','truman','trumpet','tucker','turtle','tyler','utopia','voyager','warcraft','warlock','warren',
			'water','wayne','wendy','williams','willy','winona','woody','woofwoof','wrangler','wright','xfiles','xxxxxx','yankees',
			'yvonne','zebra','zenith','zigzag','zombie','zxc123','zxcvb','000000','007007','11111','11111111','123321','171717',
			'181818','1a2b3c','1chris','4runner','54321','55555','6969','7777777','789456','88888888','Alexis','Bailey','Charlie',
			'Chris','Daniel','Dragon','Elizabeth','HARLEY','Heather','Jennifer','Jessica','Jordan','KILLER','Nicholas','Password',
			'Princess','Purple','Rebecca','Robert','Shadow','Steven','Summer','Sunshine','Superman','Taylor','Thomas','Victoria',
			'abcd123','abcde','accord','active','africa','airborne','alfaro','alicia','aliens','alina','aline','alison','allen','aloha',
			'alpha1','althea','altima','amanda1','amazing','america','amour','anderson','andre','andrew1','andromeda','angels','angie1',
			'annie','anything','apple1','apple2','applepie','april','aquarius','ariane','ariel','arlene','artemis','asdf1234','asdfjkl',
			'ashley1','ashraf','ashton','asterix','attila','autumn','avatar','babes','bambi','barbie','barney1','barrett','bball',
			'beaches','beanie','beans','beauty','becca','belize','belle','belmont','benji','benson','bernardo','berry','betsy','betty',
			'bigboss','bigred','billy1','birdie','birthday','biscuit','bitter','blackjack','blah','blanche','blood','blowjob','blowme',
			'blueeyes','blues','bogart','bombay','boobie','boots','bootsie','boxers','brandi','brent','brewster','bridge','bronco',
			'bronte','brooke','brother','bryan','bubble','buddha','budgie','burton','butterfly','byron','calendar','calvin1','camel',
			'camille','campbell','camping','cancer','canela','cannon','carbon','carnage','carolyn','carrot','cascade','catfish',
			'cathy','catwoman','cecile','celica','change','chantal','charger','cherry','chiara','chiefs','china','chris123',
			'christ1','christmas','christopher','chuck','cindy1','cinema','civic','claude','clueless','cobain','cobra','cody',
			'colette','college','colors','colt45','confused','cool','corvette','cosmo','country','crusader','cunningham','cupcake',
			'cynthia','dagger','dammit','dancer','daphne','darkstar','darren','darryl','darwin','deborah','december','deedee',
			'deeznuts','delano','delete','demon','denise','denny','desert','deskjet','detroit','devil','devine','devon','dexter',
			'dianne','diesel','director','dixie','dodgers','doggy','dollar','dolly','dominique','domino','dontknow','doogie','doudou',
			'downtown','dragon1','driver','dude','dudley','dutchess','dwight','eagle1','easter','eastern','edith','edmund','eight','element',
			'elissa','ellen','elliot','empire','enigma','enterprise','erin','escort','estelle','eugene','evelyn','explore','family1',
			'fatboy','felipe','ferguson','ferret','ferris','fireball','fishes','fishie','flight','florida1','flowerpot','forward',
			'freddie','freebird','freeman','frisco','fritz','froggie','froggies','frogs','fucku','future','gabby','games','garcia',
			'gaston','gateway','george1','georgia','german','germany1','getout','ghost','gibson','giselle','gmoney','goblin',
			'goblue','gollum','grandma','gremlin','grizzly','grumpy','guess','guitar1','gustavo','haggis','haha','hailey',
			'halloween','hamilton','hamlet','hanna','hanson','happy123','happyday','hardcore','harley1','harriet','harris',
			'harvard','health','heart','heather1','heather2','hedgehog','helene','hello1','hello123','hellohello','hermes',
			'heythere','highland','hilda','hillary','history','hitler','hobbes','holiday','holly','honda1','hongkong','hootie',
			'horse','hotrod','hudson','hummer','huskies','idiot','iforget','iloveu','impact','indonesia','irina','isabelle','israel',
			'italia','italy','jackie1','jacob','jakey','james1','jamesbond','jamie','jamjam','jeffrey1','jennie','jenny','jensen','jesse',
			'jesse1','jester','jethro','jimbob','jimmy','joanna','joelle','john316','jordie','jorge','josh','journey','joyce','jubilee',
			'jules','julien','juliet','junebug','juniper','justdoit','karin','karine','karma','katerina','katie','katie1','kayla','keeper',
			'keller','kendall','kenny','ketchup','kings','kissme','kitten','kittycat','kkkkkk','kristi','kristine','labtec','laddie',
			'ladybug','lance','laurel','lawson','leader','leland','lemon','lester','letter','letters','lexus1','libra','lights',
			'lionel','little','lizzy','lolita','lonestar','longhorn','looney','loren','lorna','loser','lovers','loveyou',
			'lucia','lucifer','lucky14','maddie','madmax','magic1','magnum','maiden','maine','management','manson','manuel',
			'marcus','maria','marielle','marine','marino','marshall','martha','maxmax','meatloaf','medical','megan','melina',
			'memphis','mermaid','miami','michel','michigan','mickey1','microsoft','mikael','milano','miles','millenium',
			'million','miranda','miriam','mission','mmmmmm','mobile','monkey1','monroe','montana','monty','moomoo',
			'moonbeam','morpheus','motorola','movies','mozart','munchkin','murray','mustang1','nadia','nadine','napoleon',
			'nation','national','nestle','newlife','newyork1','nichole','nikita','nikki','nintendo','nokia','nomore','normal',
			'norton','noway','nugget','number9','numbers','nurse','nutmeg','ohshit','oicu812','omega','openup','orchid','oreo',
			'orlando','packard','packers','paloma','pancake','panic','parola','parrot','partner','pascal','patches','patriots',
			'paula','pauline','payton','peach','peanuts','pedro1','peggy','perfect','perry','peterpan','philips','phillips',
			'phone','pierce','pigeon','pink','pioneer','piper1','pirate','pisces','playboy','pluto','poetry','pontiac','pookey',
			'popeye','prayer','precious','prelude','premier','puddin','pulsar','pussy','pussy1','qwert','qwerty12','qwertyui',
			'rabbit1','rachelle','racoon','rambo','randy1','ravens','redman','redskins','reggae','reggie','renee','renegade',
			'rescue','revolution','richard1','richards','richmond','riley','ripper','robby','roberts','rock','rocket1','rockie',
			'rockon','roger1','rogers','roland','rommel','rookie','rootbeer','rosie','rufus','rusty','ruthless','sabbath','sabina',
			'safety','saint','samiam','sammie','sammy','samsam','sandi','sanjose','saphire','sarah1','saskia','sassy','saturday',
			'science','scooby','scoobydoo','scooter1','scorpion','scotty','scouts','search','september','server','seven7','sexy',
			'shaggy','shanny','shaolin','shasta','shayne','shelly','sherry','shirley','shorty','shotgun','sidney','simba1','sinatra',
			'sirius','skate','skipper1','skyler','slayer','sleepy','slider','smile1','smitty','smoke','snakes','snapper','snoop',
			'solomon','sophia','space','sparks','spartan','spike1','sponge','spurs','squash','stargate','starlight','stars','steph1',
			'steve1','stevens','stewart','stone','stranger','stretch','strong','studio','stumpy','sucker','suckme','sultan','summit',
			'sunfire','sunset','super','superstar','surfing','susan1','sutton','sweden','sweetpea','sweety','swordfish','tabatha',
			'tacobell','taiwan','tamtam','tanner','target','tasha','tattoo','tequila','terry1','texas','thankyou','theend',
			'thompson','thrasher','tiger2','timber','timothy','tinkerbell','topcat','topher','toshiba','tototo','travis',
			'treasure','trees','tricky','trish','triton','trombone','trouble','trucker','turbo','twins','tyler1','ultimate',
			'unique','united','ursula','vacation','valley','vampire','vanessa','venice','venus','vermont','vicki','vicky','victor1',
			'vincent1','violet','violin','virgil','virginia','vision','volley','voodoo','vortex','waiting','wanker','warner','water1',
			'wayne1','webster','weezer','wendy1','western','white','whitney','whocares','wildcat','william1','wilma','window',
			'winniethepooh','wolfgang','wolverine','wonder','xxxxxxxx','yamaha','yankee','yogibear','yolanda','yomama',
			'yvette','zachary','zebras','zxcvbn','00000000','121212','1234qwer','131313','13579','90210','99999999','ABC123',
			'action','amelie','anaconda','apollo13','artist','asshole','benoit','bernard','bernie','bigbird','blizzard',
			'bluesky','bonjour','caesar','cardinal','carolina','cesar','chandler','chapman','charlie1','chevy','chiquita',
			'chocolat','coco','cougars','courtney','dolphins','dominic','donkey','dusty','eminem','energy','fearless','forest',
			'forever','glenn','guinness','hotdog','indian','jared','jimbo','johnson','jojo','josie','kristin','lloyd','lorraine',
			'lynn','maxime','memory','mimi','mirror','nebraska','nemesis','network','nigel','oatmeal','patton','pedro','planet',
			'players','portland','praise','psalms','qwaszx','raiders','rambo1','rancid','shawn','shelley','softball','speedo',
			'sports','ssssss','steele','steph','stephani','sunday','tiffany','tigre','toronto','trixie','undead','valentin',
			'velvet','viking','walker','watson','young','babygirl','pretty','hottie','teamo','987654321','naruto','spongebob',
			'daniela','princesa','christ','blessed','single','qazwsx','pokemon','iloveyou1','iloveyou2','fuckyou1','hahaha',
			'poop','blessing','blahblah','blink182','123qwe','trinity','passw0rd','google','looking','spirit','iloveyou!',
			'qwerty1','onelove','mylove','222222','ilovegod','football1','loving','emmanuel','1q2w3e4r','red123','blabla',
			'112233','hallo','spiderman','simpsons','monster','november','brooklyn','poopoo','darkness','159753','pineapple',
			'chester','1qaz2wsx','drowssap','monkey12','wordpass','q1w2e3r4','coolness','11235813','something','alexandra',
			'estrella','miguel','iloveme','sayang','princess1','555555','999999','alejandro','brittany','alejandra',
			'tequiero','antonio','987654','00000','fernando','corazon','cristina','kisses','myspace','rebelde','babygurl',
			'alyssa','mahalkita','gabriela','pictures','hellokitty','babygirl1','angelica','mahalko','mariana','eduardo',
			'andres','ronaldo','inuyasha','adriana','celtic','samsung','angelo','456789','sebastian','karina','hotmail',
			'0123456789','barcelona','cameron','slipknot','cutiepie','50cent','bonita','maganda','babyboy','natalie',
			'cuteako','javier','789456123','123654','bowwow','portugal','777777','volleyball','january','cristian','bianca',
			'chrisbrown','101010','sweet','panget','benfica','love123','lollipop','camila','qwertyuiop','harrypotter',
			'ihateyou','christine','lorena','andreea','charmed','rafael','brianna','aaliyah','johncena','lovelove','gangsta',
			'333333','hiphop','mybaby','sergio','metallica','myspace1','babyblue','badboy','fernanda','westlife','sasuke',
			'steaua','roberto','slideshow','asdfghjkl','santiago','jayson','5201314','jerome','gandako','gatita','babyko',
			'246810','sweetheart','chivas','alberto','valeria','nicole1','12345678910','leonardo','jayjay','liliana',
			'sexygirl','232323','amores','anthony1','bitch1','fatima','miamor','lover','lalala','252525','skittles','colombia',
			'159357','manutd','123456a','britney','katrina','christina','pasaway','mahal','tatiana','cantik','0123456',
			'teiubesc','147258369','natalia','francisco','amorcito','paola','angelito','manchester','mommy1','147258',
			'amigos','marlon','linkinpark','147852','diego','444444','iverson','andrei','justine','frankie','pimpin','fashion',
			'bestfriend','england','hermosa','456123','102030','sporting','hearts','potter','iloveu2','number1','212121',
			'truelove','jayden','savannah','hottie1','ganda','scotland','ilovehim','shakira','estrellita','brandon1',
			'sweets','familia','love12','omarion','monkeys','loverboy','elijah','ronnie','mamita','999999999','broken',
			'rodrigo','westside','mauricio','amigas','preciosa','shopping','flores','isabella','martinez','elaine',
			'friendster','cheche','gracie','connor','valentina','darling','santos','joanne','fuckyou2','pebbles','sunshine1',
			'gangster','gloria','darkangel','bettyboop','jessica1','cheyenne','dustin','iubire','a123456','purple1',
			'bestfriends','inlove','batista','karla','chacha','marian','sexyme','pogiako','jordan1','010203','daddy1',
			'daddysgirl','billabong','pinky','erika','skater','nenita','tigger1','gatito','lokita','maldita','buttercup',
			'bambam','glitter','123789','sister','zacefron','tokiohotel','loveya','lovebug','bubblegum','marissa','cecilia',
			'lollypop','nicolas','puppies','ariana','chubby','sexybitch','roxana','mememe','susana','baller','hotstuff','carter',
			'babylove','angelina','playgirl','sweet16','012345','bhebhe','marcos','loveme1','milagros','lilmama','beyonce',
			'lovely1','catdog','armando','margarita','151515','loves','202020','gerard','undertaker','amistad','capricorn',
			'delfin','cheerleader','password2','PASSWORD','lizzie','matthew1','enrique','badgirl','141414','dancing','cuteme',
			'amelia','skyline','angeles','janine','carlitos','justme','legolas','michelle1','cinderella','jesuschrist',
			'ilovejesus','tazmania','tekiero','thebest','princesita','lucky7','jesucristo','buddy1','regina','myself',
			'lipgloss','jazmin','rosita','chichi','pangit','mierda','741852963','hernandez','arturo','silvia','melvin',
			'celeste','pussycat','gorgeous','honeyko','mylife','babyboo','loveu','lupita','panthers','hollywood','alfredo',
			'musica','hawaii','sparkle','kristina','sexymama','crazy','scarface','098765','hayden','micheal','242424',
			'0987654321','marisol','jeremiah','mhine','isaiah','lolipop','butterfly1','xbox360','madalina','anamaria',
			'yourmom','jasmine1','bubbles1','beatriz','diamonds','friendship','sweetness','desiree','741852','hannah1',
			'bananas','julius','leanne','marie1','lover1','twinkle','february','bebita','87654321','twilight','imissyou',
			'pollito','ashlee','cookie1','147852369','beckham','simone','nursing','torres','damian','123123123','joshua1',
			'babyface','dinamo','mommy','juliana','cassandra','redsox','gundam','0000','ou812','dave','golf','molson','Monday',
			'newpass','thx1138','1','Internet','coke','foobar','abc','fish','fred','help','ncc1701d','newuser','none','pat','dog',
			'duck','duke','floyd','guest','joe','kingfish','micro','sam','telecom','test1','7777','absolut','babylon5','backup',
			'bill','bird33','deliver','fire','flip','galileo','gopher','hansolo','jane','jim','mom','passwd','phil','phish',
			'porsche911','rain','red','sergei','training','truck','video','volvo','007','1969','5683','Bond007','Friday',
			'Hendrix','October','Taurus','aaa','alexandr','catalog','challenge','clipper','coltrane','cyrano','dan','dawn',
			'dean','deutsch','dilbert','e-mail','export','ford','fountain','fox','frog','gabriell','garlic','goforit','grateful',
			'hoops','lady','ledzep','lee','mailman','mantra','market','mazda1','metallic','ncc1701e','nesbitt','open','pete',
			'quest','republic','research','supra','tara','testing','xanadu','xxxx','zaphod','zeus','0007','1022','10sne1',
			'1973','1978','2000','2222','3bears','Broadway','Fisher','Jeanne','Killer','Knight','Master','Pepper','Sierra',
			'Tennis','abacab','abcd','ace','acropolis','amy','anders','avenir','basil','bass','beer','ben','bliss','blowfish',
			'boss','bridges','buck','bugsy','bull','cannondale','canon','catnip','chip','civil','content','cook','cordelia',
			'crack1','cyber','daisie','dark1','database','deadhead','denali','depeche','dickens','emmitt','entropy','farout',
			'farside','feedback','fidel','firenze','fish1','fletch','fool','fozzie','fun','gargoyle','gasman','gold','graphic',
			'hell','image','intern','intrepid','jeff','jkl123','joel','johanna1','kidder','kim','king','kirk','kris','lambda',
			'leon','logical','lorrie','major','mariner','mark1','max','media','merlot','midway','mine','mmouse','moon','mopar',
			'mortimer','nermal','nina','olsen','opera','overkill','pacers','packer','picard','polar','polo','primus',
			'prometheus','public','radio','rastafarian','reptile','rob','robotech','rodeo','rolex','rouge','roy','ruby',
			'salasana','scarecrow','scout','scuba1','sergey','skibum','skunk','sound','starter','sting1','sunbird','tbird',
			'teflon','temporal','terminal','the','thejudge','time','toby','today','tokyo','tree','trout','vader','val','valhalla',
			'windsurf','wolf','wolf1','xcountry','yoda','yukon','1213','1214','1225','1313','1818','1975','1977','1991','1kitty',
			'2001','2020','2112','2kids','333','4444','5050','57chevy','7dwarfs','Animals','Ariel','Bismillah','Booboo','Boston',
			'Carol','Computer','Creative','Curtis','Denise','Eagles','Esther','Fishing','Freddy','Gandalf','Golden','Goober',
			'Hacker','Harley','Henry','Hershey','Jackson','Jersey','Joanna','Johnson','Katie','Kitten','Liberty','Lindsay',
			'Lizard','Madeline','Margaret','Maxwell','Money','Monster','Pamela','Peaches','Peter','Phoenix','Piglet','Pookie',
			'Rabbit','Raiders','Random','Russell','Sammy','Saturn','Skeeter','Smokey','Sparky','Speedy','Sterling','Theresa',
			'Thunder','Vincent','Willow','Winnie','Wolverine','aaaa','aardvark','abbott','acura','admin','admin1','adrock',
			'aerobics','agent','airwolf','ali','alien','allegro','allstate','altamira','altima1','andrew!','ann','anne','anneli',
			'aptiva','arrow','asdf;lkj','assmunch','baraka','barnyard','bart','bartman','beasty','beavis1','bebe','belgium',
			'beowulf','beryl','best','bharat','bichon','bigal','biker','bilbo','bills','bimmer','biochem','birdy','blinds',
			'blitz','bluejean','bogey','bogus','boulder','bourbon','boxer','brain','branch','britain','broker','bucks',
			'buffett','bugs','bulls','burns','buzz','c00per','calgary','camay','carl','cat','cement','cessna','chad','chainsaw',
			'chameleon','chang','chess','chinook','chouette','chronos','cicero','circuit','cirque','cirrus','clapton',
			'clarkson','class','claudel','cleo','cliff','clock','color','comet','concept','concorde','coolbean','corky',
			'cornflake','corwin','cows','crescent','cross','crowley','cthulhu','cunt','current','cutlass','daedalus','dagger1',
			'daily','dale','dana','daytek','dead','decker','dharma','dillweed','dipper','disco','dixon','doitnow','doors',
			'dork','doug','dutch','effie','ella','elsie','engage','eric1','ernie1','escort1','excel','faculty','fairview',
			'faust','fenris','finance','first','fishhead','flanders','fleurs','flute','flyboy','flyer','franka','frederic',
			'free','front242','frontier','fugazi','funtime','gaby','gaelic','gambler','gammaphi','garfunkel','garth','gary',
			'gateway2','gator1','gibbons','gigi','gilgamesh','goat','godiva','goethe','gofish','good','gramps','gravis','gray',
			'greed','greg','greg1','greta','gretzky','guido','gumby','h2opolo','hamid','hank','hawkeye1','health1','hello8',
			'help123','helper','homerj','hoosier','hope','huang','hugo','hydrogen','ib6ub9','insight','instructor','integral',
			'iomega','iris','izzy','jazz','jean','jeepster','jetta1','joanie','josee','joy','julia2','jumbo','jump','justice4',
			'kalamazoo','kali','kat','kate','kerala','kids','kiwi','kleenex','kombat','lamer','laser','laserjet','lassie1',
			'leblanc','legal','leo','life','lions','liz','logger','logos','loislane','loki','longer','lori','lost','lotus',
			'lou','macha','macross','madoka','makeitso','mallard','marc','math','mattingly','mechanic','meister','mercer',
			'merde','merrill','michal','michou','mickel','minou','mobydick','modem','mojo','montana3','montrose','motor',
			'mowgli','mulder1','muscle','neil','neutrino','newaccount','nicklaus','nightshade','nightwing','nike','none1',
			'nopass','nouveau','novell','oaxaca','obiwan','obsession','orville','otter','ozzy','packrat','paint','papa',
			'paradigm','pass','pavel','peterk','phialpha','phishy','piano1','pianoman','pianos','pipeline','plato','play',
			'poetic','print','printing','provider','qqq111','quebec','qwer','racer','racerx','radar','rafiki','raleigh',
			'rasta1','redcloud','redfish','redwing','redwood','reed','rene','reznor','rhino','ripple','rita','robocop',
			'robotics','roche','roni','rossignol','rugger','safety1','saigon','satori','saturn5','schnapps','scotch',
			'scuba','secret3','seeker','services','sex','shanghai','shazam','shelter','sigmachi','signal','signature',
			'simsim','skydive','slick','smegma','smiths','smurfy','snow','sober1','sonics','sony','spazz','sphynx','spock',
			'spoon','spot','sprocket','starbuck','steel','stephi','sting','stocks','storage','strat','strato','stud','student2',
			'susanna','swanson','swim','switzer','system5','t-bone','talon','tarheel','tata','tazdevil','tester','testtest',
			'thisisit','thorne','tightend','tim','tom','tool','total','toucan','transfer','transit','transport','trapper',
			'trash','trophy','tucson','turbo2','unity','upsilon','vedder','vette','vikram','virago','visual','volcano','walden',
			'waldo','walleye','webmaster','wedge','whale1','whit','whoville','wibble','will','wombat1','word','world','x-files',
			'xxx123','zack','zepplin','zoltan','zoomer','123go','21122112','5555','911','FuckYou','Fuckyou','Gizmo','Hello',
			'Michel','Qwerty','Windows','angus','aspen','ass','bird','booster','byteme','cats','changeit','christia',
			'christoph','classroom','cloclo','corrado','dasha','fiction','french1','fubar','gator','gilles','gocougs',
			'hilbert','hola','home','judy','koko','lulu','mac','macintosh','mailer','mars','meow','ne1469','niki','paul',
			'politics','pomme','property','ruth','sales','salut','scrooge','skidoo','spain','surf','sylvie','symbol',
			'forum','rotimi','god','saved','2580','1998','xxx','1928','777','info','a','netware','sun','tech','doom','mmm',
			'one','ppp','1911','1948','1996','5252','Champs','Tuesday','bach','crow','don','draft','hal9000','herzog','huey',
			'jethrotull','jussi','mail','miki','nicarao','snowski','1316','1412','1430','1952','1953','1955','1956','1960',
			'1964','1qw23e','22','2200','2252','3010','3112','4788','6262','Alpha','Bastard','Beavis','Cardinal','Celtics',
			'Cougar','Darkman','Figaro','Fortune','Geronimo','Hammer','Homer','Janet','Mellon','Merlot','Metallic','Montreal',
			'Newton','Paladin','Peanuts','Service','Vernon','Waterloo','Webster','aki123','aqua','aylmer','beta','bozo',
			'car','chat','chinacat','cora','courier','dogbert','eieio','elina1','fly','funguy','fuzz','ggeorge','glider1',
			'gone','hawk','heikki','histoire','hugh','if6was9','ingvar','jan','jedi','jimi','juhani','khan','lima','midvale',
			'neko','nesbit','nexus6','nisse','notta1','pam','park','pole','pope','pyro','ram','reliant','rex','rush','seoul',
			'skip','stan','sue','suzy','tab','testi','thelorax','tika','tnt','toto1','tre','wind','x-men','xyz','zxc','369','Abcdef',
			'Asdfgh','Changeme','NCC1701','Zxcvbnm','demo','doom2','e','good-luck','homebrew','m1911a1','nat','ne1410s','ne14a69',
			'zhongguo','sample123','0852','basf','OU812','!@#$%','informix','majordomo','news','temp','trek','!@#$%^','!@#$%^&*',
			'Pentium','Raistlin','adi','bmw','law','m','new','opus','plus','visa','www','y','zzz','1332','1950','3141','3533','4055','4854',
			'6301','Bonzo','ChangeMe','Front242','Gretel','Michel1','Noriko','Sidekick','Sverige','Swoosh','Woodrow','aa','ayelet',
			'barn','betacam','biz','boat','cuda','doc','hal','hallowell','haro','hosehead','i','ilmari','irmeli','j1l2t3','jer','kcin',
			'kerrya','kissa2','leaf','lissabon','mart','matti1','mech','morecats','paagal','performa','prof','ratio','ship','slip',
			'stivers','tapani','targas','test2','test3','tula','unix','user1','xanth','!@#$%^&','1701d','@#$%^&','Qwert','allo',
			'dirk','go','newcourt','nite','notused','sss'
		);
		foreach ( $toppwds as $key=>$val )
		{
			$this->add_hash_lib_model->query_hash_test($val);
		};
	}
}
?>
