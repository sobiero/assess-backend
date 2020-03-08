<?php

namespace Project\Evaluation\Services;

class Document
{

    public static function upload($data, $app)
    {

		$docs = [];
     
		if ($app->request->hasFiles() == true) {

			$x = 0;

			foreach ($app->request->getUploadedFiles() as $file) {

				$saved_name = uniqid() . "_" . $file->getName() ;
				
				if ( @$file->moveTo($app->config->app->upload_dir . $saved_name ) ) {
				

					$doc = !empty($data['doc_id']) ? 
						\Project\Evaluation\Models\Document::findFirst($data['doc_id']) :
						new \Project\Evaluation\Models\Document() ;

					$doc->evaluation_id           = $data['evaluation_id'];
					$doc->belongs_to_menu_item_id = $data['belongs_to_menu_item_id'];
					$doc->title                   = $data['title'];
					$doc->description             = $data['description'];
					$doc->publication_date        = $data['publication_date'];
					$doc->original_name           = $file->getName();
					$doc->saved_name              = $saved_name ;
					$doc->type                    = $file->getType();
					$doc->size_in_bytes           = $file->getSize();
					$doc->upload_by_user_email    = getUser();

					$doc->save();

					$docs[$x] = $doc ;

					$x++;

				} else {

					throw new Exception('Error saving file in the server');
				
				}

			}

		} else {

			if ( !empty($data['doc_id']) ) {

				$doc = \Project\Evaluation\Models\Document::findFirst($data['doc_id']) ;

				$doc->title                   = $data['title'];
				$doc->description             = $data['description'];
				$doc->publication_date        = $data['publication_date'];
				$doc->save();
			
				$docs[0] = $doc ;
			}
		
		}

		return $docs;
	   
    }

}
