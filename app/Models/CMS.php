<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMS extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_banner_title',
        'home_banner_subtitle',
        'button_text',
        'home_banner',
        'home_banner_two',
        'home_banner_three',
        'home_banner_four',
        'home_banner_five',
        'about_page_title',
        'about_page_banner',
        'blog_page_title',
        'blog_page_banner',
        'blog_details_title',
        'blog_details_banner',
        'contact_page_title',
        'contact_page_banner',
    ];

      //for api image with url retrieve
      public function getHomeBannerAttribute($value): string | null
      {
          if (request()->is('api/*') && !empty($value)) {
              return url($value);
          }
          return $value;
      }
      public function getHomeBannerTwoAttribute($value): string | null
      {
          if (request()->is('api/*') && !empty($value)) {
              return url($value);
          }
          return $value;
      }
      public function getHomeBannerThreeAttribute($value): string | null
      {
          if (request()->is('api/*') && !empty($value)) {
              return url($value);
          }
          return $value;
      }
      public function getHomeBannerFourAttribute($value): string | null
      {
          if (request()->is('api/*') && !empty($value)) {
              return url($value);
          }
          return $value;
      }
      public function getHomeBannerFiveAttribute($value): string | null
      {
          if (request()->is('api/*') && !empty($value)) {
              return url($value);
          }
          return $value;
      }
      public function getAboutPageBannerAttribute($value): string | null
      {
          if (request()->is('api/*') && !empty($value)) {
              return url($value);
          }
          return $value;
      }
      public function getBlogPageBannerAttribute($value): string | null
      {
          if (request()->is('api/*') && !empty($value)) {
              return url($value);
          }
          return $value;
      }
      public function getBlogDetailsBannerAttribute($value): string | null
      {
          if (request()->is('api/*') && !empty($value)) {
              return url($value);
          }
          return $value;
      }
      public function getContactPageBannerAttribute($value): string | null
      {
          if (request()->is('api/*') && !empty($value)) {
              return url($value);
          }
          return $value;
      }


}
