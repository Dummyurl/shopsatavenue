	<?php if ( $this->session->userdata['credit_amount'] > 0 ) { ?>
    	<div class="cart"><strong>$<?php echo $this->session->userdata['credit_amount']; ?></strong></div>
    <?php } ?>
	<?php if ( $this->session->userdata['userType'] == 'Seller' ) { ?>
            <div class="cart">
                <a href="merchant-home"><!--<i class="fa fa-university"></i>--><img width="24" height="24" src="images/shop.png" title="shop" alt="shop" class="img-responsive"  />
</a>
            </div>
    <?php } ?>
<div class="cart">
    <a href="javascript:;">
        <i class="fa fa-user"></i>
    </a>
    <div class="cart-content">
        <div class="cart-item">
            <div class="cart-des">
                <a href="public-profile">My Profile</a>
            </div><!-- cart des -->
        </div><!-- cart item --> <!-- cart item -->

        <div class="cart-item">
            <div class="cart-des">
                <a href="purchase-review">Orders</a>
            </div><!-- cart des -->
        </div><!-- cart item -->
        
        <div class="cart-item">
            <div class="cart-des">
                <a href="site/user/mylikes">My Likes</a>
            </div><!-- cart des -->
        </div><!-- cart item -->

        <div class="cart-item">
            <div class="cart-des">
                <a href="user-email-settings">Emails</a>
            </div><!-- cart des -->
        </div><!-- cart item -->

        <div class="cart-item">
            <div class="cart-des">
                <a href="manage-notification">Notifications</a>
            </div><!-- cart des -->
        </div><!-- cart item -->

        <div class="cart-item">
            <div class="cart-des">
                <a href="my-offers">My Discount Offers</a>
            </div><!-- cart des -->
        </div><!-- cart item -->

        <div class="cart-item">
            <div class="cart-des">
                <a href="contact-support">Contact Support</a>
            </div><!-- cart des -->
        </div><!-- cart item -->

        <div class="cart-item">
            <div class="cart-des">
                <a href="logout">Logout</a>
            </div><!-- cart des -->
        </div><!-- cart item --><!-- cart-bottom -->
    </div> <!-- cart content -->
</div>
<div class="cart" >
    <a href="placeOrder">
    <img width="24" height="24" src="images/cart.png" title="shop" alt="shop" class="img-responsive"  />
    <!--<i class="fa fa-shopping-cart"></i>-->
    <?php if( $this->session->userdata('cart_quantity') != 0 ) : ?>
        <?php echo '<span id="#cartCount">' . $this->session->userdata('cart_quantity') .'</span>'; ?>
    <?php endif; ?>
    </a>
</div>
