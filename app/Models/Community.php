<?php
/**
 * This model handles relationships related to Communities for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\User;
use App\ExchangeType;
use Watson\Validating\ValidatingTrait;
use App\UploadableFileTrait;
use Log;

class Community extends Model
{

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'communities';

    /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
    * @var boolean
    */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;
    use UploadableFileTrait;

    protected $rules = [
      'name'            => 'required|string|min:2|max:255',
      'subdomain'       => 'required|alpha_dash|min:2|max:255|unique:communities,subdomain,NULL,deleted_at',
      'group_type'      => 'required',
    ];

    /*
    * Set traits for uploadable image
    */

    public static $uploadableImgs = [
      'community-covers' =>
        [
          'height' => '300',
          'width' => '1300',
        ],
      'community-logos' =>
        [
          'height' => '40',
          'width' => '250',
        ],
      'community-profiles' =>
        [
          'height' => '250',
          'width' => '250',
        ],
    ];


    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['name','subdomain','group_type','cover_img','profile_img','logo'];

    /**
    * Relationship to get community owner
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function owner()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
    * Relationship for entries and communities
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function entries()
    {
        return $this->belongsToMany('App\Entry', 'entries_community_join', 'community_id', 'entry_id');
    }


    /**
    * Get the members of a group.
    * Groups belong to many users by way of the communities_users table.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function members()
    {
        return $this->belongsToMany('App\User', 'communities_users', 'community_id', 'user_id')->withPivot('is_admin');
    }


    /**
    * Get the cover image url based on app environment
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return string
    */
    public function getCover()
    {

        if ($this->cover_img!='') {
            $cover_img = Config::get('services.cdn.default').'/uploads/community-covers/'.$this->id.'/'.$this->cover_img;
        } else {
            $cover_img = Config::get('services.cdn.default').'/img/covers/default-heart-cover.jpg';
        }
        return $cover_img;
    }


    /**
    * Get the logo image url based on app environment
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return string
    */
    public function getLogo()
    {

        if ($this->logo) {
            return Config::get('services.cdn.default').'/uploads/community-logos/'.$this->id.'/'.$this->logo;
        } else {
            return false;
        }
    }

    /**
    * Get the profile image url based on app environment
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return string
    */
    public function getProfileImg()
    {

        if ($this->profile_img!='') {
            return Config::get('services.cdn.default').'/uploads/community-profiles/'.$this->id.'/'.$this->profile_img;
        } else {
            return false;
        }
    }


    /**
    * Relationship for community subscription
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function subscription()
    {
        return $this->hasOne('\App\Subscription', 'id', 'community_id');
    }


    /**
    * Save the image to the DB. This method handles cover images, logos and profile images.
    *
    * @todo   Remove upload key, since it's not used here.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return boolean
    */
    public static function saveImageToDB($id, $filename, $type, $upload_key = null)
    {

        if ($community = Community::find($id)) {

            switch ($type) {
            case 'community-covers':
                $community->cover_img = $filename;
                break;
            case 'community-profiles':
                $community->profile_img = $filename;
                break;
            case 'community-logos':
                $community->logo = $filename;
                break;
            }

            if (!$community->save()) {
                return false;
            }
        }

        return false;
    }

    /**
    * Get the exchange types allowed in this community.
    * ExchangeType Types belong to many communities by way of the group_allowed_types table.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function exchangeTypes()
    {
        $exchanges = $this->belongsToMany('App\ExchangeType', 'community_allowed_types', 'community_id', 'type_id')->withTimestamps();

        return $exchanges;
    }


    /**
    * Query scope to only return publicly viewable communities.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeIsPublic()
    {
        return $this->where('group_type', '!=', 'S');
    }


    /**
    * scopeEntriesInCommunity
    * Get all entries that are in the current community
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @param  $query
    * @param  array $categoryIdListing
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeEntriesInCommunity($query)
    {
        return $query->whereIn('category_id', $categoryIdListing);
    }


}
