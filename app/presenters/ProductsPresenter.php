<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

class ProductsPresenter extends BasePresenter
{

protected function startup()
{
    parent::startup();
    if (!$this->getUser()->isLoggedIn()) {
       $this->redirect('Sign:in');
    }
}
public function renderDefault()
{
	
    $products = $this->database->table('product');

  
	/*foreach ($products as $product) {

	    foreach ($product->related('image') as $image) {
	        $images[$product->id] =  $image;
	    }

	}

	$this->template->images = $images;
	*/
   
 
    $this->template->products = $products;
    
}

public function renderOrig()
{
    
    $this->template->products = $this->database->table('PRODUKTY');
}

public function renderEdit($product_id)
{
    
    $product = $this->database->table('product')->get($product_id);
    if (!$product) {
        $this->error('Produkt nebyl nalezen');
    }
    $this->template->product = $product;

    $lang = $this->template->lang = $product->related('product_lang');

    $trans = [];
    foreach ($lang as $v) {
    	$trans[$v->lang][$v->string]=$v->trans;
 
    }

    $this["productEditForm"]->setDefaults(array(
    			"code" => $product->code,
    			"name" => $product->name,
    			"descrip" => $product->descrip,
    			"size" => $product->size,
    			"colors" => $product->colors,
    			"theme" => $product->theme,
    			"price1" => $product->price1,
    			"price2" => $product->price2,

    			"name_en" => isset ($trans['en']['name']) ? $trans['en']['name'] : '',
    			"descrip_en" => isset ($trans['en']['descrip']) ? $trans['en']['descrip'] : '',

    			"name_it" => isset ($trans['it']['name']) ? $trans['it']['name'] : '',
    			"descrip_it" => isset ($trans['it']['descrip']) ? $trans['it']['descrip'] : ''


        ));
}

public function actionDelete($product_id)
{
	$this->database->table('product_lang')
    ->where('product_id', $product_id)
    ->delete();
    
     $this->database->table('product')
    ->where('id', $product_id)
    ->delete();

	

    $this->flashMessage('Prudukt  byl smazán.', 'alert alert-danger');

   $this->redirect('Products:');
}


protected function createComponentProductEditForm()
{
    $form = new Form; // means Nette\Application\UI\Form
    $form->addGroup('Kód');
    $form->addText('code', 'Kód')
    	->setOption('class', 'form-control-lg')
        ->setRequired();

    $form->addGroup('Popis produktu');

    $form->addText('name', 'Jméno')
        ->setRequired();
     
     $form->addText('descrip', 'Popis');
     
     $form->addGroup('Popis produktu EN');

    $form->addText('name_en', 'Jméno')
        ->setRequired();
     
     $form->addText('descrip_en', 'Popis');

     $form->addGroup('Popis produktu IT');

    $form->addText('name_it', 'Jméno')
        ->setRequired();
     
     $form->addText('descrip_it', 'Popis');
     
   $form->addGroup('Detaily produktu');  

    $form->addText('size', 'Velikost');
     
     $form->addText('colors', 'Barvy');

     $form->addText('theme', 'Motiv');

     $form->addGroup('Ceny');  

      $form->addText('price1', 'Cena CZ');

     $form->addText('price2', 'Cena Praha');
     


    $form->addSubmit('send', 'Uložit');

     $form->onSuccess[] = [$this, 'registrationFormSucceeded'];

    /*var_dump($form);
    die();*/
    return $form;
}

public function registrationFormSucceeded(Nette\Application\UI\Form $form, $values)
    {
    	$product_id  = $this->getParameter('product_id');
      
    	$vals = [
	        	'code'=>$values['code'],
	        	'name'=>$values['name'],
	        	'descrip'=>$values['descrip'],
	        	'size'=>$values['size'],
	        	'colors'=>$values['colors'],
	        	'theme'=>$values['theme'],
	        	'price1'=>$values['price1'],
	        	'price2'=>$values['price2']
	        ];

	        $langs =['en', 'it'];
	        $strings = ['name', 'descrip'];

		if ($product_id) {
	        $product = $this->database->table('product')->get($product_id);
	        $product->update($vals);

	    

	        foreach($langs as $l) {
	        	foreach($strings as $s) {
	        		 $this->database->table('product_lang')
			        ->where([
					   	'product_id' => $product_id,
					    'lang' => $l,
					    'string' => $s,
						])
		        	->update([
			        	'trans'=>$values[$s.'_'.$l]
			        ]);

	        	}	

	        }
	       

	    } else {
	        $new_product_id  = $this->database->table('product')->insert($vals);
	    
	        foreach($langs as $l) {
	        	foreach($strings as $s) {
	        		 $this->database->table('product_lang')			   
		        	->insert([
		        		'lang' =>$l,
		        		'string' =>$s,
		        		'product_id' => $new_product_id,
			        	'trans' => $values[$s.'_'.$l]
			        ]);

	        	}	

	        }
	    }

         $this->flashMessage('Prudukt '. $product_id.' byl uložen.', 'alert alert-success');
    	
    	//$this->redirect('this');

        $this->redirect('Products:');
    }

public function renderImport()
{
	
    
/*    $this->template->products = $this->database->table('PRODUKTY');

    foreach ($this->template->products as $product) {

    	$this->database->query('INSERT INTO product', [ 
			    'code' => $product->KatalogoveCislo,
			    'name' => $product->NazevProduktuCZE,
			    'descrip' => $product->JineInfoCZE,
			    'size' => $product->VyskaProduktu,
			    'colors' => $product->Barvy
		]);


		$product_id = $this->database->getInsertId();

		$this->database->query('INSERT INTO product_lang', [ 
			    'product_id' => $product_id,
			    'lang' => 'en',
			    'string' => 'title',
			    'trans' => $product->NazevProduktuENG
			    
		]);

		$this->database->query('INSERT INTO product_lang', [ 
			    'product_id' => $product_id,
			    'lang' => 'en',
			    'string' => 'descrip',
			    'trans' => $product->JineInfoENG
			    
		]);

		$this->database->query('INSERT INTO product_lang', [ 
			    'product_id' => $product_id,
			    'lang' => 'it',
			    'string' => 'title',
			    'trans' => $product->NazevProduktuITA
			    
		]);

		$this->database->query('INSERT INTO product_lang', [ 
			    'product_id' => $product_id,
			    'lang' => 'it',
			    'string' => 'descrip',
			    'trans' => $product->JineInfoITA
			    
		]);

		$this->database->query('INSERT INTO image', [ 
			    'product_id' => $product_id,
			    'path' => $product->VelkyObrazek
			    
		]);
    }*/
    

    die('finished');
}

}
