<?php

require('../../config/config.inc.php');
require('../../init.php');

header('Content-type: application/json; charset=utf-8');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



class Ozon {

    public $id_product;
    public $product;
    public $link ;
    public $images;
    public $productInJB = true;
    public $OzonTask;

    public function __construct($id)
        {
            $this->id_product  = $id;
            $this->link = new Link;
            $this->product = new Product($id, false, 2, 1);
            if($this->product->reference == NULL)
                {
                    $this->productInJB = false;
                }
        }

    public function price()
        {
            return strval(Product::getPriceStatic($this->id_product));
        }

    public function priceOld()
        {
            return (string)(int)$this->product->price;
        }

    public function description()
        {
            return strip_tags($this->product->description.' '.$this->product->description_short);
        }
    
    public function arrReferenceQuantityRasmer()
        {   
            $ref = $this->product->reference;
            $attr = $this->product->getAttributesResume(2);
            $attrQuantity = [];
            $i = 0;
            foreach ($attr as $keyArr => $valueArr) 
                {   
                    if($valueArr['quantity'] > 0)
                        {
                            $razmer = substr($valueArr['attribute_designation'], 15);
                            $attrQuantity[$i]['reference'] = $ref.'/'.$razmer;
                            $attrQuantity[$i]['quantity'] = $valueArr['quantity'];
                            $attrQuantity[$i]['razmer'] = $razmer;
                            $i++;
                        }
                }

            return $attrQuantity;
        }
    
    public function name()
        {
            return $this->product->name;
        }
    public function vendor()
        {
            return Manufacturer::getNameById((int)$this->product->id_manufacturer);
        }
    
    public function productImg()
        {
            $images = [];
            $i = 0;
            if (++$i == 2) break;
            $imgArr = $this->product->getImages(2);
            foreach ($imgArr as $key => $value) 
                {
                    
                    if( $value['cover'] == 1)
                        {
                            $images[] = (object)
                                [
                                    "file_name" => 'https://'.strval($this->link->getImageLink(isset($this->product->link_rewrite) ? $this->product->link_rewrite : $this->product->name, (int)$value['id_image'])),
                                    "default" => true
                                ];
                        }else{
                            $images[] = (object)
                                [
                                
                                    "file_name" => 'https://'.strval($this->link->getImageLink(isset($this->product->link_rewrite) ? $this->product->link_rewrite : $this->product->name, (int)$value['id_image'])),
                                    "default" => false
                                ];
                        }
                    if (++$i == 10) break;
                }
            return $images;
        }

    public function allCategoryArr()
        {
            $arrCategory = Category::getCategories(2);
            $resArrCat = [];
            $i = 0;
            foreach ($arrCategory as $keyArr => $valueArr) 
                {
                    foreach ($valueArr as $keys => $infos) 
                        {
                            foreach ($infos as $key => $value) 
                                {
                                    $resArrCat[$i]['id_category'] = $value['id_category'];
                                    $resArrCat[$i]['name'] = $value['name'];
                                    $i++;
                                }
                        }
                }
            $prodCat = $this->product->getProductCategoriesFull($this->id_product);
            return $resArrCat;
        }
    public function category()
        {
            $defCat = $this->product->id_category_default;
            $res = [];
            if($defCat == '209')
                {
                    $res['ozonCat'] = 17029735;
                    $res['title'] = 'Куртка мужская';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 10943, 'name' => 'Кожаная куртка'];
                    $res['AttrVidOdez'] = ['id'=> 4610, 'value' => 101, 'name' => 'кожаная'];
             
                }elseif ($defCat == '208')
                {
                    $res['ozonCat'] = 17029735;
                    $res['title'] = 'Куртка мужская';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 10942, 'name' => 'Джинсовая куртка'];
                    $res['AttrVidOdez'] = ['id'=> 4610, 'value' => 100, 'name' => 'джинсовая'];
                 
                }elseif ($defCat == '213')
                {
                    $res['ozonCat'] = 17037054;
                    $res['title'] = 'Пиджак мужской';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 2469, 'name' => 'Пиджак'];
          
                    
                }elseif ($defCat == '408')
                {
                    $res['ozonCat'] = 17029733;
                    $res['title'] = 'Ветровка мужская';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 2357, 'name' => 'Ветровка'];

                }elseif (in_array($defCat, ['207', '308' , '410']))
                {
                    $res['ozonCat'] = 17029735;
                    $res['title'] = 'Куртка мужская';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 2431, 'name' => 'Куртка'];
          
                }elseif ($defCat == '223')
                {
                    $res['ozonCat'] = 17037058;
                    $res['title'] = 'Толстовка, свитшот мужские';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 2527, 'name' => 'Толстовка'];
                 
                }elseif ($defCat == '251')
                {
                    $res['ozonCat'] = 17037058;
                    $res['title'] = 'Толстовка, свитшот мужские';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 2510, 'name' => 'Свитшот'];
                   
                }elseif ($defCat == '223')
                {
                    $res['ozonCat'] = 17037056;
                    $res['title'] = 'Рубашка мужская';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 2503, 'name' => 'Рубашка'];
                }elseif ($defCat == '225')
                {
                    $res['ozonCat'] = 17029721;
                    $res['title'] = 'Футболка мужская';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 2539, 'name' => 'Футболка'];
                }elseif ($defCat == '293')
                {
                    $res['ozonCat'] = 17037059;
                    $res['title'] = 'Поло мужское';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 2488, 'name' => 'Поло'];
                }elseif ($defCat == '203')
                {
                    $res['ozonCat'] = 17029728;
                    $res['title'] = 'Джинсы мужское';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 2370, 'name' => 'Джинсы'];
                }elseif ($defCat == '232')
                {
                    $res['ozonCat'] = 17029725;
                    $res['title'] = 'Брюки мужские';
                    $res['AttrType'] = ['id'=> 8229, 'value' => 2344, 'name' => 'Брюки'];
                    $res['AttrVidOdez'] = ['id'=> 4610, 'value' => 147, 'name' => 'карго'];
            }
            if(!empty($res))
            {
                return $res;
            }
            
           return false;
        }

    public function dimensions()
        {
            $dimensions = [];
            if(in_array($this->product->id_category_default, ['235','207','209','208', '308', '213', '408', '410']))
                {
                   $dimensions["height"] = 15;
                   $dimensions["depth"] = 30;
                   $dimensions["width"] = 40;
                   $dimensions["dimension_unit"] = 'cm';
                   $dimensions["weight"] = 1000;
                   $dimensions["weight_unit"] = 'g';
                }else
                {
                   $dimensions["height"] = 10;
                   $dimensions["depth"] = 30;
                   $dimensions["width"] = 30;
                   $dimensions["dimension_unit"] = 'cm';
                   $dimensions["weight"] = 700;
                   $dimensions["weight_unit"] = 'g';
                }

                return $dimensions;
        }
    

    public function razmer($razm)
        {
            $razmer = 
                [       
                    'S'     => '2',
                    'M'     => '3',
                    'L'     => '4',
                    'XL'    => '5',
                    'XXL'   => '6',
                    'XXXL'  => '149',
                    '48'    => '3',
                    '50'    => '4',
                    '52'    => '5',
                    '54'    => '6',
                    '56'    => '149',
                    '58'    => '153',
                    '28'    => '1',
                    '29'    => '1;2',
                    '30'    => '2',
                    '31'    => '2;3',
                    '32'    => '3',
                    '33'    => '3;4',
                    '34'    => '4',
                    '35'    => '4;5',
                    '36'    => '5',
                    '38'    => '6',
                    '40'    => '149',
                    '42'    => '153',
                    '28/30' => '456',
                    '28/32' => '1134',
                    '28/34' => '1135',
                    '28/36' => '1138',
                    '29/30' => '456;459',
                    '29/32' => '1136;1134',
                    '29/34' => '1135;1137',
                    '29/36' => '1138;1149',
                    '30/30' => '459',
                    '30/32' => '1136',
                    '30/34' => '1137',
                    '30/36' => '1149',
                    '31/30' => '459;462',
                    '31/32' => '1136;626',
                    '31/34' => '1137;627',
                    '31/36' => '1149;1147',
                    '31/38' => '1163;1',
                    '32/30' => '462',
                    '32/32' => '626',
                    '32/34' => '627',
                    '32/36' => '1147',
                    '32/38' => '1163',
                    '33/30' => '462;464',
                    '33/32' => '626;628',
                    '33/34' => '627;629',
                    '33/36' => '1147;1132',
                    '33/38' => '1163;1166',
                    '34/30' => '464',
                    '34/32' => '628',
                    '34/34' => '629',
                    '34/36' => '1132',
                    '34/38' => '1166',
                    '35/30' => '464;467',
                    '35/32' => '628;630',
                    '35/34' => '629;631',
                    '35/36' => '1132;1133',
                    '35/38' => '1166;1148',
                    '36/30' => '467',
                    '36/32' => '630',
                    '36/34' => '631',
                    '36/36' => '1133',
                    '36/38' => '1148',
                    '38/30' => '470',
                    '38/32' => '632',
                    '38/34' => '633',
                    '38/36' => '188',
                    '38/38' => '1169', 
                    '40/30' => '1142',
                    '40/32' => '1126',
                    '40/34' => '635',
                    '40/36' => '1139',
                    '40/38' => '1168',
                    '42/30' => '1143',
                    '42/32' => '1128',
                    '42/34' => '1127',
                    '42/36' => '1144',
                    '42/38' => '1167',
                ];
            if( isset($razmer[$razm]) )
                {
                    return $razmer[$razm];
                }
            return '219';
            
        }
    
    public function filtrRazmerJeans($razm)
        {
            $razmerJeans =
                [
                    '28/30' => '90',
                    '28/32' => '106',
                    '28/34' => '128',
                    '28/36' => '145',
                    '29/30' => '91',
                    '29/32' => '107',
                    '29/34' => '129',
                    '29/36' => '146',
                    '30/30' => '92',
                    '30/32' => '108',
                    '30/34' => '130',
                    '30/36' => '147',
                    '31/30' => '93',
                    '31/32' => '109',
                    '31/34' => '131',
                    '31/36' => '148',
                    '32/30' => '94',
                    '32/32' => '110',
                    '32/34' => '132',
                    '32/36' => '149',
                    '32/38' => '1163',
                    '33/30' => '581',
                    '33/32' => '581',
                    '33/34' => '581',
                    '33/36' => '581',
                    '33/38' => '581',
                    '34/30' => '464',
                    '34/32' => '628',
                    '34/34' => '629',
                    '34/36' => '1132',
                    '34/38' => '1166',
                    '35/30' => '889',
                    '35/32' => '889',
                    '35/34' => '889',
                    '35/36' => '889',
                    '35/38' => '889',
                    '36/30' => '467',
                    '36/32' => '630',
                    '36/34' => '631',
                    '36/36' => '1133',
                    '36/38' => '1148',
                    '38/30' => '470',
                    '38/32' => '632',
                    '38/34' => '633',
                    '38/36' => '188',
                    '38/38' => '1169', 
                    '40/30' => '1142',
                    '40/32' => '1126',
                    '40/34' => '635',
                    '40/36' => '1139',
                    '40/38' => '1168',
                    '42/30' => '1143',
                    '42/32' => '1128',
                    '42/34' => '1127',
                    '42/36' => '1144',
                    '42/38' => '1167',
                ];
                if( isset($razmerJeans[$razm]) )
                {
                    return $razmerJeans[$razm];
                }
            return '407';
        }    
    
    public function filtrRuRazmer($razmer)
        {
            $ruRazm = 
                [
                    'S'     => '16',
                    'M'     => '17',
                    'L'     => '18',
                    'XL'    => '19',
                    'XXL'   => '20',
                    'XXXL'  => '21',
                    '46'    => '16',
                    '48'    => '17',
                    '50'    => '18',
                    '52'    => '19',
                    '54'    => '20',
                    '56'    => '21',
                    '58'    => '22',
                    '28'    => '15',
                    '29'    => '222',
                    '30'    => '16',
                    '31'    => '223',
                    '32'    => '17',
                    '33'    => '18',
                    '34'    => '18',
                    '35'    => '889',
                    '36'    => '19',
                    '38'    => '20',
                    '40'    => '21',
                    '42'    => '22',
                    '28/30' => '15',
                    '28/32' => '15',
                    '28/34' => '15',
                    '28/36' => '15',
                    '29/30' => '15;16',
                    '29/32' => '15;16',
                    '29/34' => '15;16',
                    '29/36' => '15;16',
                    '30/30' => '16',
                    '30/32' => '16',
                    '30/34' => '16',
                    '30/36' => '16',
                    '31/30' => '16;17',
                    '31/32' => '16;17',
                    '31/34' => '16;17',
                    '31/36' => '16;17',
                    '31/38' => '16;17',
                    '32/30' => '17',
                    '32/32' => '17',
                    '32/34' => '17',
                    '32/36' => '17',
                    '32/38' => '17',
                    '33/30' => '17;18',
                    '33/32' => '17;18',
                    '33/34' => '17;18',
                    '33/36' => '17;18',
                    '33/38' => '17;18',
                    '34/30' => '18',
                    '34/32' => '18',
                    '34/34' => '18',
                    '34/36' => '18',
                    '34/38' => '18',
                    '35/30' => '18;19',
                    '35/32' => '18;19',
                    '35/34' => '18;19',
                    '35/36' => '18;19',
                    '35/38' => '18;19',
                    '36/30' => '19',
                    '36/32' => '19',
                    '36/34' => '19',
                    '36/36' => '19',
                    '36/38' => '19',
                    '38/30' => '20',
                    '38/32' => '20',
                    '38/34' => '20',
                    '38/36' => '20',
                    '38/38' => '20', 
                    '40/30' => '21',
                    '40/32' => '21',
                    '40/34' => '21',
                    '40/36' => '21',
                    '40/38' => '21',
                    '42/30' => '22',
                    '42/32' => '22',
                    '42/34' => '22',
                    '42/36' => '22',
                    '42/38' => '22',
                ];
                if( isset($ruRazm[$razmer]) )
                {
                    return $ruRazm[$razmer];
                }
            return '407';
        }
    public function filtrWorldRazmer($razmer)
        {
            $worldRazmer =
                [
                    'S'     => '5',
                    'M'     => '4',
                    'L'     => '6',
                    'XL'    => '7',
                    'XXL'   => '8',
                    'XXXL'  => '9',
                    '48'    => '4',
                    '50'    => '6',
                    '52'    => '7',
                    '54'    => '8',
                    '56'    => '9',
                    '58'    => '10',
                    '28'    => '3',
                    '29'    => '3;5',
                    '30'    => '5',
                    '31'    => '5;4',
                    '32'    => '4',
                    '33'    => '4;6',
                    '34'    => '6',
                    '35'    => '6;7',
                    '36'    => '7',
                    '38'    => '8',
                    '40'    => '9',
                    '42'    => '10', 
                    '28/30' => '3',
                    '28/32' => '3',
                    '28/34' => '3',
                    '28/36' => '3',
                    '29/30' => '3;5',
                    '29/32' => '3;5',
                    '29/34' => '3;5',
                    '29/36' => '3;5',
                    '30/30' => '5',
                    '30/32' => '5',
                    '30/34' => '5',
                    '30/36' => '5',
                    '31/30' => '5;4',
                    '31/32' => '5;4',
                    '31/34' => '5;4',
                    '31/36' => '5;4',
                    '31/38' => '5;4',
                    '32/30' => '4',
                    '32/32' => '4',
                    '32/34' => '4',
                    '32/36' => '4',
                    '32/38' => '4',
                    '33/30' => '4;6',
                    '33/32' => '4;6',
                    '33/34' => '4;6',
                    '33/36' => '4;6',
                    '33/38' => '4;6',
                    '34/30' => '6',
                    '34/32' => '6',
                    '34/34' => '6',
                    '34/36' => '6',
                    '34/38' => '6',
                    '35/30' => '6;7',
                    '35/32' => '6;7',
                    '35/34' => '6;7',
                    '35/36' => '6;7',
                    '35/38' => '6;7',
                    '36/30' => '7',
                    '36/32' => '7',
                    '36/34' => '7',
                    '36/36' => '7',
                    '36/38' => '7',
                    '38/30' => '8',
                    '38/32' => '8',
                    '38/34' => '8',
                    '38/36' => '8',
                    '38/38' => '8', 
                    '40/30' => '9',
                    '40/32' => '9',
                    '40/34' => '9',
                    '40/36' => '9',
                    '40/38' => '9',
                    '42/30' => '10',
                    '42/32' => '10',
                    '42/34' => '10',
                    '42/36' => '10',
                    '42/38' => '10',   
                ];
            if( isset($worldRazmer[$razmer]) )
                {
                    return $worldRazmer[$razmer];
                }
            return '407';
        }
    
   public function color($colorJB)
        {
            $colorJBLower = str_replace(' ', '',mb_strtolower($colorJB));
            $color =
                [
                    'черный'     => '4',
                    'хаки'       => '44',
                    'cиний'      => '11',
                    'cерый'      => '6',
                    'оранжевый'  => '15',
                    'оливковый'  => '35',
                    'красный'    => '9',
                    'коричневый' => '5',
                    'коралловый' => '31',
                    'зеленый'    => '13',
                    'желтый'     => '8',
                    'горчичный'  => '46',
                    'голубой'    => '14',
                    'бордовый'   => '20',
                    'бирюзовый'  => '25',
                    'белый'      => '1',
                    'бежевый'    => '3',
                    'розовый'    => '10',
                ];
            if( isset($color[$colorJBLower]) )
                {
                    return $color[$colorJBLower];
                }
            return '47';
        }

    public function manufacturerCountry($manufacturerJB)
        {
            $manufacturer = $colorJBLower = str_replace(' ', '',mb_strtolower($manufacturerJB));
            $manufacturerOzon =
                [
                    'индонезия' => '43',
                    'тайланд'   => '34',
                    'таиланд'   => '34',
                    'пакистан'  => '52',
                    'китай'     => '2',
                    'нидерланды'=> '31',
                    'тунис'     => '72',       
                    'маврикий'  => '110',
                    'индия'     => '18',
                    'турция'    => '11',
                    'албания'   => '146',
                    'бангладеш' => '40',
                    'португалия'=> '26',
                    'россия'    => '1',
                    'вьетнам'   => '37',
                    'италия'    => '4',
                    'украина'   => '25',
                ];
            if( isset($manufacturerOzon[$manufacturer]) )
                {
                    return $manufacturerOzon[$manufacturer];
                }
            return '31';
        }

    public function features()
        {
            $res = [];
            $features = Product::getFrontFeaturesStatic(2, $this->id_product);
            foreach ($features as $key => $value) 
                {
                    $res[$value['name']] = $value['value'] ; 
                }
            return $res;
        }   

    public function attributes($razmerJB)
        {
            $defCat = $this->product->id_category_default;
            $features = $this->features();
            $category = $this->category();
            $combination = $this->arrReferenceQuantityRasmer();
            $atributes = [];
            $atributes[] = (object)['id' => (int)$category["AttrType"]["id"], "value" => (string)$category["AttrType"]["value"]];
            if( isset($category['AttrVidOdez']) )
                {
                   $atributes[] = (object)['id' => (int)$category["AttrVidOdez"]["id"], "value" => (string)$category["AttrVidOdez"]["value"]];
                }
            $atributes[] = (object)['id' => 4295 , 'value' => $this->razmer($razmerJB)];
            $atributes[] = (object)['id' => 4495 , 'value' => '3'];
            $atributes[] = (object)['id' => 4503 , 'value' => '24'];
            $atributes[] = (object)['id' => 8292 , 'value' => (string)strtok($this->product->reference, '/')];
            $atributes[] = (object)['id' => 9040 , 'value' => $this->color($features['Цвет'])];
            $atributes[] = (object)['id' => 9163 , 'value' => '1'];
            $atributes[] = (object)['id' => 9390 , 'value' => '1'];
            $atributes[] = (object)['id' => 4501 , 'value' => '9'];
            $atributes[] = (object)['id' => 4300 , 'value' => '4'];
            $atributes[] = (object)['id' => 4389 , 'value' => $this->manufacturerCountry($features['Завод изготовитель'])];
            if(isset($features['Cостав']))
                {
                    $atributes[] = (object)['id' => 4604 , 'value' => $features['Cостав']];
                }
            $atributes[] = (object)['id' => 9533 , 'value' => $razmerJB] ;

            if( $defCat == '203')
                {
                    $atributes[] = (object)['id' => 9695 , 'value' => $this->filtrRazmerJeans($razmerJB)] ;
                }else{
                    $atributes[] = (object)['id' => 9695 , 'value' => $this->filtrRuRazmer($razmerJB)] ;
                    $atributes[] = (object)['id' => 9696 , 'value' => $this->filtrWorldRazmer($razmerJB)] ;
                }


            return $atributes;


        }
    
    public function createObjectToSendOzon()
        {
            $product =[];
            $category = $this->category();
            $dimensions = $this->dimensions();
            $combination = $this->arrReferenceQuantityRasmer();
            
            $items = [];
            foreach ($combination as $key => $RefQuaRaz) 
                {
                    
                    $product = [];
                    $product["description"]     = $this->description();
                    $product["category_id"]     = $category["ozonCat"];
                    $product["name"]            = $this->name();
                    $product["offer_id"]        = strval($RefQuaRaz['reference']);
                    $product["price"]           = $this->price();
                    if($this->priceOld() < $this->price())
                        {
                            $product["old_price"] = $this->priceOld();
                        }
                   
                    $product["premium_price"]   = ((string)($this->price() * 0.95));
                    $product["vat"]             = "0";
                    $product["vendor"]          = $this->vendor();
                    $product["height"]          = $dimensions["height"];
                    $product["depth"]           = $dimensions["depth"];
                    $product["width"]           = $dimensions["width"];
                    $product["dimension_unit"]  = $dimensions["dimension_unit"];
                    $product["weight"]          = $dimensions["weight"];
                    $product["weight_unit"]     = $dimensions["weight_unit"];
                    $product["images"]          = $this->productImg();
                    $product["attributes"]      = $this->attributes($RefQuaRaz['razmer']);
                    $items['items'][] = (object)$product;
                    break;
                }
            

            return (object)$items;

        }

        public function curlSendToOzon()
            {
                if($this->productInJB)
                    {
                        if( $this->productWasSend())
                            {
                                $curl_data = json_encode($this->createObjectToSendOzon(), JSON_UNESCAPED_UNICODE);
                                    /*  "attribute_type": "required",
                                        "category_id": 17036076,
                                        "language": "EN"
                                    }*/

                                $myCurl = curl_init();
                                curl_setopt_array($myCurl, array(
                                CURLOPT_URL => 'http://api-seller.ozon.ru/v1/product/import',
                                CURLOPT_HTTPHEADER => array(
                                        "Content-Type: application/json",
                                        "Client-Id: 61940",
                                        "Api-Key: 375aeac9-c9bf-4677-baa2-95d8388d9386"
                                    ),
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_POST           => 1,            // i am sending post data
                                CURLOPT_POSTFIELDS     => $curl_data,
                    
                                ));

                                $response = curl_exec($myCurl);
                                curl_close($myCurl);
                                $res = json_decode($response, true);
                                if( isset($res["result"]["task_id"]) )
                                    {
                                        $this->dbAddOzonTask($res["result"]["task_id"]);
                                        $this->OzonTask = $res["result"]["task_id"];
                                    }else{
                                        echo 'Task in ozon not create';
                                    }
                                return var_dump($res);
                            }else{
                                return var_dump('This product id = '.$this->id_product.' was sent');  
                            }
                    }else{
                        return var_dump('This product id = '.$this->id_product.' not exist in store');   
                    }  
            }
        
        public function productWasSend()
            {
                $query = 'SELECT task_id FROM ps_ozon_task WHERE product_id='.$this->id_product.'';
                if( empty(Db::getInstance()->executeS($query)) )
                    {
                        return true;
                    }
                return false;
            }

        public function dbAddOzonTask($id)
            {
                $insertArr = 
                    [
                        'task_id' => $id,
                        'product_reference' => $this->product->reference,
                        'product_id' => $this->id_product
                    ];
               // $query = 'INSERT INTO ozon_task (task_id, product_reference,product_id) VALUES ('.$id.','.$this->product->reference.','.$this->id_product.')';
                return Db::getInstance()->insert('ozon_task',  $insertArr);
                //return $this->id_product;
            }
   
            public function dbAddOzonProduct()
                {
                
                        $curl_data = json_encode(['task_id'=> '6689610'], JSON_UNESCAPED_UNICODE);
                                    /*  "attribute_type": "required",
                                        "category_id": 17036076,
                                        "language": "EN"
                                    }*/

                                    $myCurl = curl_init();
                                    curl_setopt_array($myCurl, array(
                                    CURLOPT_URL => 'http://api-seller.ozon.ru/v1/product/import/info',
                                    CURLOPT_HTTPHEADER => array(
                                        "Content-Type: application/json",
                                        "Client-Id: 61940",
                                        "Api-Key: 375aeac9-c9bf-4677-baa2-95d8388d9386"
                                                ),
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_POST           => 1,            // i am sending post data
                                    CURLOPT_POSTFIELDS     => $curl_data,
                                
                                            ));
            
                                            $response = curl_exec($myCurl);
                                            curl_close($myCurl);
                                            $res = json_decode($response, true);
                                            return var_dump($res);
                                        
                                
                }
            public function updateProduct($id)
                {
                    $product = [];
                    $product['product_id'] = $id;
                    $product['images'] = $this->productImg();
                    $pr = (object)$product;
                   // return var_dump((object)$product);

                    $curl_data = json_encode($pr, JSON_UNESCAPED_UNICODE);

                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                CURLOPT_URL => 'http://api-seller.ozon.ru/v1/product/update',
                CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "Client-Id: 61940",
                        "Api-Key: 375aeac9-c9bf-4677-baa2-95d8388d9386"
                    ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => 1,           
                CURLOPT_POSTFIELDS     => $curl_data,
    
                ));

                $response = curl_exec($myCurl);
                curl_close($myCurl);
                $res = json_decode($response, true);
                return $res;
                }
}

$ozon = new Ozon(4783);
//var_dump($ozon->productInJB);
//var_dump($ozon->features());
var_dump($ozon->createObjectToSendOzon());
//$ozon->curlSendToOzon();
//$ozon->dbAddOzonProduct();
//var_dump($ozon->updateProduct(34654840));
//$ozon->dbAddOzonProduct();
//var_dump(new Product(2351, false, 2, 1));
//var_dump(ProductCore::getById(0));
//var_dump($ozon->dbAddOzonTask(6490939));
//var_dump($ozon->createObjectToSendOzon());
//var_dump(json_encode($ozon->createObjectToSendOzon(), JSON_UNESCAPED_UNICODE));
