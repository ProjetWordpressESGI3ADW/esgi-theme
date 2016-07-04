				<footer>
					<?php
						 if(has_nav_menu('secondary_menu')){
								wp_nav_menu(array('theme_location'=>'secondary_menu'));
							}?>
				</footer>
				<?php wp_footer();?>
			</div>
		</div>
	</div>
</html>
