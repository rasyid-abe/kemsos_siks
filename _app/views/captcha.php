
<!-- captcha -->
	<div class="m-t-10 m-b-10" >	
		<?php echo $captha_image['image']; ?>
		<input type="text" name="captcha_input" placeholder="Ketik captcha disini..." required/>
		<input type="hidden" value="<?php echo $captha_image['word'] ?>" name="code_cap" />
	</div>    
    <button class="btn btn-block btn-primary mb-3">Signin</button>
<!-- end-captcha -->