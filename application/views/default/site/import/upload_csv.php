<?php $this->load->view('site/templates/merchant_header'); ?>
<style>
.choose-file { border:0.1rem solid #d8d5d5; height:4rem; margin-top:10px; width:100%; float:left; display:inline-block; cursor:pointer; }
.choose-file div { padding-left:1.5rem; padding-top:0.9rem; }
.choose-file div span { padding-left:1.5rem; font-size:small;  }
</style>

<div class="container" >
    <div class="row">
    	<div class="col-md-12"><h3>Upload CSV File</h3></div>
        <form id="frmUpload" name="frmUpload" action="" method="post" enctype="multipart/form-data" >
                <input type="file" id="csv_file" name="csv_file" value="" onchange="return csv_file_change();" style="display:none;"  />
        </form>
        <div class="col-md-6" >
            <p style="margin-top:20px;" >Click "Select File" to browse your computer for CSV product file, then click "Import Products" button to submit your products.</p>
            <div id="choose-file" class="choose-file" >
                <div><b>Select File </b><span>No file selected</span></div>
            </div>
        	<div class="col-md-5 col-md-push-3"><button class="button1" type="button" name="btn-import" onclick="return upload_csv_products();" >Import Products</button></div>
        </div>
        <div class="col-md-6 text-center" >
             <h4>Download CSV File Format</h4>
            <div class="col-xs-12" style="padding-top:20px;" >
                <div>Make your product CSV as shown in the sample file.</div>
                <div class="col-md-8 col-xs-12 col-md-push-2" style="margin-top:20px;" >
                <a href="uploads/sample_files/product_import_sample_file.csv" class="button1" type="button" name="btn-import" onclick="" ><i class="fa fa-download"></i>&nbsp;Download Sample File</a>					
                </div>

        </div>
    </div>
</div>

<?php $this->load->view('site/templates/footer',$this->data); ?>

<script type="text/javascript" >
$('#choose-file').click( function() { 
	$('#csv_file').trigger('click');
});

function csv_file_change() {
	if( $('#csv_file').val() != '' ) {
		$('#choose-file div span').html( $('#csv_file').val() );
	}
}

function upload_csv_products() {
	if( $('#csv_file').val() == '' ) {
		alert( 'Please select CSV file' );
		return false;
	}

	var fd = new FormData(  );
	fd.append( 'csv_file',  $( "input[type=\'file\']" )[0].files[0] );
	//var formData = new FormData($('form')[0]);
	$('<span class="fa fa-spin fa-spinner fa-2x">').insertAfter( $('button[name=btn-import]').closest('div') );
	$('button[name=btn-import]').prop('disabled', true);
	
	$.ajax({
		type: 'post',
		url: 'site/product_import/csv_product_import',
		data: fd,
  		dataType: 'json',
		success: function ( res )
		{
			if( res.status == 'success' ) {
				alert( res.message );
				$('.fa-spinner').remove();
			}
			if( res.status == 'error' ) {
				alert( res.message );
				$('button[name=btn-import]').prop('disabled', false);
			}
		},
		error: function (error)
		{
			console.log(error.statusText);
			//alert("Exception thrown : " + error.statusText );
		},
        cache: false,
        contentType: false,
        processData: false
	});

}

</script>