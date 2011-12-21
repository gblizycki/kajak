<?php

/**
 * SocialProfile embedded document
 * 
 * @author Grzegorz Blizycki <grzegorzblizycki@gmail.com>
 * @package models
 * @category user
 */
class SocialProfile extends CMongoEmbeddedDocument
{
	public $Facebook;
	public $Twitter;
	public $NK;
	public $Google;
	public $Yahoo;
	public $MySpace;
	public $Amazon;
	public $LinkedIn;
	public $OpenID;
	public $Gravatar;
	public $OAuthID;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('FacebookID, TwitterID, NaszaKlasaID, GoogleID, YahooID, MySpaceID, AmazonID, LinkedInID, OpenID, GraavatarID, OAuthID', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Facebook' => 'Facebook',
			'Twitter' => 'Twitter',
			'NK' => 'Nasza Klasa',
			'Google' => 'Google',
			'Yahoo' => 'Yahoo',
			'MySpace' => 'My Space',
			'Amazon' => 'Amazon',
			'LinkedIn' => 'Linked In',
			'OpenID' => 'Open',
			'Gravatar' => 'Gravatar',
			'OAuthID' => 'Oauth',
		);
	}
}