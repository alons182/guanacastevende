<?php namespace App\Newsletters;


interface NewsletterList {

    /**
     * @param $listName
     * @param $email
     * @param $fname
     * @param $lname
     * @return mixed
     */
    public function subscribeTo($listName, $email, $fname, $lname);

    /**
     * @param $listName
     * @param $email
     * @return mixed
     */
    public function unsubscribeFrom($listName, $email);



}