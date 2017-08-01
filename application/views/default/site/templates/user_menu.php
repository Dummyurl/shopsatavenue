	<?php 
		if ( $this->session->userdata['userType'] = 'User' ) { 
			 $profile = true;
			 $email_setting = false;
			 $notification = false;
			 $support = false;
			 $myoffers = $mylikes = false;
//echo "GV:" . $this->uri->segment(1,0); exit(0);

			 if ( $this->uri->segment(1,0) == 'public-profile' ) { $profile = true;  }
			 elseif ( $this->uri->segment(1,0) == 'user-email-settings' ) { $email_setting = true; $profile = false;  }
			 elseif ( $this->uri->segment(1,0) == 'manage-notification' ) { $notification = true; $profile = false;  }
			 elseif ( $this->uri->segment(1,0) == 'contact-support' ) { $support = true; $profile = false;  }
			 elseif ( $this->uri->segment(1,0) == 'my-offers' ) { $myoffers = true; $profile = false;  }
			 elseif ( $this->uri->segment(3,0) == 'mylikes' ) { $mylikes = true; $profile = false;  }
			 elseif ( $this->uri->segment(1,0) == 'purchase-review' ) { $myorder = true; $profile = false;  }
	?>
        <div class="container" >
            <div class="user-menu">
                <ul role="menu" class="nav nav-tabs">
                    <li class="<?php echo $profile ? 'active' : '';?>"><a aria-expanded="true" href="public-profile" aria-controls="descreption" >My Profile</a></li>
                    <li class="<?php echo $myorder ? 'active' : '';?>" ><a aria-expanded="false" href="purchase-review"  >Orders</a></li>
                    <li class="<?php echo $mylikes ? 'active' : '';?>" ><a aria-expanded="false" href="myLikes" >My Likes</a></li>
                    <li class="<?php echo $email_setting ? 'active' : '';?>" ><a aria-expanded="false" href="user-email-settings"  >Emails</a></li>
                    <li class="<?php echo $notification ? 'active' : '';?>" ><a aria-expanded="false" href="manage-notification"  >Notifications</a></li>
                    <li class="<?php echo $myoffers ? 'active' : ''; ?>" ><a aria-expanded="false" href="my-offers"  >My Discount Offers</a></li>
                    <li class="<?php echo $support ? 'active' : '';?>" ><a aria-expanded="false" href="contact-support"  >Contact Support</a></li>
                </ul>
            </div>
       </div>
	<?php } ?>