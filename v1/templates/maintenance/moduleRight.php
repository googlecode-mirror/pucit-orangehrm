
 <label for="chkAdd"><?php echo $lang_Admin_Users_add; ?></label>
        <input type="checkbox" name="chkAdd" id="chkAdd" value="1" class="formCheckboxWide"/>

        <label for="chkEdit"><?php echo $lang_Admin_Users_edit; ?></label>
        <input type="checkbox" name="chkEdit" id="chkEdit" value="1" class="formCheckboxWide"/>
        <br class="clear"/>

        <label for="chkDelete"><?php echo $lang_Admin_Users_delete; ?></label>
        <input type="checkbox" name="chkDelete" id="chkDelete" value="1" class="formCheckboxWide"/>

        <label for="chkView"><?php echo $lang_Admin_Users_view; ?></label>
        <input type="checkbox" name="chkView" id="chkView" value="1" class="formCheckboxWide"/>
        <br class="clear"/>
        <div class="formbuttons">
                    <input type="submit" class="savebutton" id="saveBtn" tabindex="5" onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                        value="<?php echo $lang_Common_Save;?>" title="<?php echo $lang_Common_Save;?>" />
                    <input type="submit" class="clearbutton"  onclick="resetChkBoxes()"tabindex="5" onmouseover="moverButton(this);" onmouseout="moutButton(this);"
                        value="<?php echo $lang_Common_Reset;?>" title="<?php echo $lang_Common_Reset;?>" />

        </div>