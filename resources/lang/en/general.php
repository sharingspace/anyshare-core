<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Site Language Lines
    |--------------------------------------------------------------------------
    */

    'browse_button' => 'Browse Here',
    'copyright' => 'Copyright',
    'no_about_data'  => 'The owner of this group has not entered any information about it yet.',
    'seo_title' => 'Build a Sharing Website with AnyShare',
    'token_expired' => 'Oops! Your security token has expired. Please try reloading the page and trying again.',


    'nav'  => [
          'browse' => 'Browse',
          'create' => 'Create',
          'try_it' => 'Free Trial',
          'start_now' => 'START NOW',
          'login' => 'Sign-In',
          'logout' => 'Logout',
          'register' => 'Sign-Up',
          'about_mission' => 'Mission',
					'basics' => 'Basics',
          'examples' => 'Examples',
          'features' => 'Features',
          'members' => 'Members',
          'settings' => 'Settings',
          'profile' => 'Profile',
          'create_sharing_hub' => 'Create',
					'order_history' => 'Order History',
          'tos' => 'Terms and Conditions',
    ],

    'entries'  => [
          'entry' => 'Entry',
          'post_type' => 'Type',
          'want' => 'Want',
          'have' => 'Have',
          'title' => 'Entry',
          'title_placeholder' => 'Description',
          'details_placeholder' => 'Details',
          'tag_placeholder' => 'Keywords, comma-separated',
          'location_placeholder' => 'Near (optional)',
          'qty' => 'QTY',
          'author' => 'Author',
          'posted_by' => 'Posted by',
          'tags' => 'Keywords',
          'location' => 'Location',
          'created_at' => 'Created on',
					'exchange_types' => 'Exchange Types',
          'keywords' => 'Keywords',
          'actions' => 'Actions',
          'view' => 'View Entry',
          'create' => 'Create Entry',
          'save_entry' => 'Save',
					'create_subheadline' => 'What do you want or have? Press "Enter" to make an new entry',
          'cancel' => 'Cancel',
          'edit' => 'Edit Entry',
          'browse_entries' => 'Browse entries',
          'file_placeholder' => 'no file selected (jpg, png, gif. Max size is 4MB)',
          'max_file_size' => 'The maximum file size is 4MB',
          'max_size' => '4096000',
          'remove' => 'Remove',
          'visible' => 'Visible only to you',

          'messages' => [
            'invalid' => 'That entry is not valid.',
            'no_image' => 'No image was supplied',
            'completed' => 'Completed! ',
            'save_edits' => 'Your entry has been updated!',
            'upload_fail' => "Your image failed to upload",
            'not_allowed' => 'You are not allowed to edit this entry',
            'delete_success' => 'Your entry has been deleted',
            'delete_failed' => 'Something went wrong. Your entry could not be deleted',
						'delete_not_allowed' => 'You are not allowed to delete this entry.',
            'save_new' => 'Your new entry has been created!',
            'save_failed' => 'Something went wrong. Your entry edit has not been saved',
            'upload_failed' => 'Something went wrong. Your uploaded image has not been saved',
            'errors' => 'Your entry was not saved due to the following errors: ',
            'error' => 'Your entry was not saved due to the following error: ',
            'no_exchange_types' => 'An exchange type was not selected',
            'rotation_failed' => 'Something went wrong. We could not rotate and save your image' 
          ],
    ],

    'user'  => [
      'first_name'  => 'First Name',
      'last_name'  => 'Last Name',
      'display_name'  => 'Name',
      'email'  => 'Email',
      'password'  => 'Password',
      'confirm_password'  => 'Confirm Password',
      'change_settings' => 'Change your settings',
      'save_password' => 'Save Password Changes',
      'save_personal_info' => 'Save Personal Info Changes',
      'save_privacy' => 'Save Privacy Changes',
      'save_socials' => 'Save Social Link Changes',
      'social_success' => 'Your social settings have been updated',
      'social_failure' => 'Something went wrong. Your social settings have not been saved',
      'save_avatar' => 'Save Avatar Changes',
      'avatar_success' => 'Your avatar has been updated',
      'avatar_failure' => 'Something went wrong. Your uploaded image has not been saved',
      'latin_chars' => 'Only latin characters and numbers',
      'login_by_email' => 'Sign-in with email',
      'login_by_social' => 'or with a social network',
      'signup_by_email' => 'Sign-up with email',
      'verify_account' => 'Needed to verify your account'
    ],

    'community'  => [
      'community'  => 'Sharing Hub',
      'settings'  => 'Sharing Hub Settings',
      'members'  => 'Member|Members',
      'save' => 'Update',
      'create' => 'Start your own Sharing Hub for Free!',
      'name_placeholder' => 'My awesome sharing hub',
      'name' => 'Name for your Sharing Hub',
      'subdomain' => ' Subdomain (xxx.anysha.re) for your Sharing Hub',
      'subdomain_placeholder' => 'your hubname.anysha.re',
      'description' => 'Describe your sharing hub',
      'detailed_description' => 'Detailed description',
      'exchange_options' => 'Choose the allowed exchange options',
      'all_exchanges' => 'All exchanges',
      'choose_theme' => 'Choose a theme',
      'slack_integration' => 'Slack integration',
      'slack_endpoint' => 'Slack endpoint',
      'slack_bot_name' => 'Slack bot name',
      'slack_channel' => 'Slack channel name',
      'analytics' => 'Google analytics integration',
      'ga_tracking_id' => 'Google analytics tracking id',
      'for_example' => 'For example: UA-000000-01',
      'p1' => 'You can start a sharing hub in under 1 minute and enjoy it free for 15 days.
      We are currently in beta, so keep in mind features are still being added. This
      introductory cost is available for a limited time only. Email us at information
      info@anysha.re with questions about current features.',
      'p2' => 'You will not be charged until your free trial ends on',
      'p3' => 'No commitments, cancel at any time.',
      'save_success' => 'Welcome to your new sharing hub! Get started adding entries now.',
      'type' => 'Choose a privacy level',
      'payment_info' => 'credit card information',
      'after_trial' => 'after 15 day free trial',
      'start_trial' => '15 day Free Trial',
      'monthly' => 'Monthly',
      'month' => 'Month',
      'year' => 'Year',
      'annual' => 'Annual',
      'card_num' => 'Card Number',
      'cvc' => 'CVC',
      'coupon' => 'Coupon',
      'have_coupon' => 'I have a coupon code',
      'coupon_code' => 'Coupon Code',
      'edit_hub' => 'EDIT SHARING HUB',
      'basic' => 'Basic',
      'images' => 'Images',
      'advanced' => 'Advanced',
      'wrong' => 'Something went wrong :(',
      'sub_type' => 'Subscription Type',
        'exchange_types' => [
          'title' => 'Exchange Type|Exchange Types',
          'all_allowed' => 'All exchange types welcome',
        ],

        'open'  => [
          'title'  => 'Open Sharing Hub',
          'text'  => 'Anyone can join',
          'type' => 'Open'
        ],
        'closed'  => [
          'title'  => 'Closed Sharing Hub',
          'text'  => 'Invite-only to post',
          'type' => 'Closed'
        ],
        'secret'  => [
          'title'  => 'Secret Sharing Hub',
          'text'  => 'Only members can view',
          'type' => 'Secret'
        ],

        'messages' => [
          'save_edits' => 'Your sharing hub settings have been saved',
          'save_new' => 'Your new sharing hub has been created!',
          'save_failed' => 'Something went wrong. Your sharing hub settings have not been saved',
        ],

        'slack_info' => [
          'p1' => 'Slack is a messaging app for teams (https://slack.com/). AnyShare integrates with slack to allow you to add entries and show members from within the app.',
          'p2' => 'To list members, type: /members <hub subdomain>',
          'p3' => 'To add an entry, type: /want <qty> <example text> in:<hub subdomain> and /have <qty> <example text> in:<hub subdomain>',
          'p4' => 'The <qty> is optional, and if it\'s missing, it will default to one. For example, /have <example text> in:<hub subdomain> is the same as /have 1 <example text> in:<hub subdomain>.',
          'p5' => 'New entries added through the slash command will have all of the exchange types available for that hub selected.',
         ]

    ],
    'members' => [
      'members' => 'Members',
    ],

    'uploads'  => [
      'choose_file'  => 'Choose image',
      'banner_tip' => 'Tip. Images with an aspect ratio of 4:1 will fit exactly.',
      'logo_tip' => 'Tip. For best results, use an image that is 250px x 40px.',
      'cover_image' => 'Cover image'
    ],


    'profile'  => [
      'profile'  => 'Profile for ',
    ],

    'messages'      => [
      'inbox'       => 'Messages Inbox',
      'from'        => 'From',
      'created_at'  => 'Sent On',
      'message'       => 'Message',
      'message_from'  => 'Message From :name',
      'sent' => 'Your message has been sent',

        'messages' => [
            'unauthorized' => 'You are not authorized to view that conversation.',
            'not_found' => 'That conversation does not exist.',
        ],

    ],



];
