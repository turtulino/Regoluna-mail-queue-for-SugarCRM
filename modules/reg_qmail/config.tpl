{*

/**
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 *
 * @package regoluna_mail_queue
 * @author Rodrigo Saiz Camarero <rodrigo@regoluna.com>
 */

*}

<script type='text/javascript' src='include/javascript/overlibmws.js'></script>
<br>
<form name="ConfigureSettings" enctype='multipart/form-data' method="POST" action="index.php?module=reg_qmail&action=config" onSubmit="return (add_checks(document.ConfigureSettings) && check_form('ConfigureSettings'));">
  <span class='error'>{$error.main}</span>
  <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td style="padding-bottom: 2px;">
        <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button"  type="submit"  name="save" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " >
      &nbsp;<input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " > </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td>
    <br />

<!-- Informacion sobre el facturador -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabForm">
      <tr>
        <th align="left" class="dataLabel" colspan="4">
          <h2>{$MOD.LBL_REG_QMAIL_CONFIG_QUEUE}</h2>
        </th>
      </tr><tr>
        <td>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%" class="dataLabel">
                {$MOD.LBL_QMAIL_BATCH_SIZE}:
              </td>
              <td class="dataField" >
                <input name='reg_qmail_batch_size' type="text" size="6" maxlength="6" value="{$config.reg_qmail_batch_size}">
              </td>
              <td class="dataField">
                <i>{$MOD.LBL_QMAIL_BATCH_SIZE_DESC}</i>
              </td>
              <td class="dataField" rowspan="3">
                <p>
                <strong>{$MOD.LBL_CREATED_BY} Rodrigo Saiz Camarero<br/>rodrigo@regoluna.com</strong><br/><br/>
                </p><p>
                <a href="http://www.regoluna.com"><img style="border:0;" src="{$regoluna_logo}"></img></a>
                
                </p>
                <p>
                <strong>{$MOD.LBL_SPONSORED_BY}</strong><br/>
                <a href="http://www.nubola-saas.com"><img style="border:0;" src="{$sponsor1}"></img></a>
                </p>
              </td>
            </tr>
            <tr>
              <td width="15%" class="dataLabel">
                {$MOD.LBL_QMAIL_MAX_TIME}:
              </td>
              <td class="dataField" >
                <input name='reg_qmail_max_time' type="text" size="6" maxlength="6" value="{$config.reg_qmail_max_time}">
              </td>
              <td colspan="" class="dataField">
                <i>{$MOD.LBL_QMAIL_MAX_TIME_DESC}</i>
              </td>
            </tr>
            <tr>
              <td width="15%" class="dataLabel">{$MOD.LBL_QMAIL_DELETE}: </td>
              <td width="20%" class="dataField">
                <select name="reg_qmail_delete">{$reg_qmail_delete_options}</select>
              </td>
              <td colspan="" class="dataField">
                <i>{$MOD.LBL_QMAIL_DELETE_DESC}</i>
              </td>
            </tr>

          </table>
      </td></tr>
    </table>

  </table>
  <br />
  <div style="padding-top: 2px;">
    <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button"  type="submit" name="save" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " />
    &nbsp;<input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " />
  </div>
  {$JAVASCRIPT}
  {literal}
  <script>
    addToValidate('ConfigureSettings', 'system_name', 'varchar', true,'System Name' );
  </script>
  <!-- 
  <script type="text/javascript" language="Javascript" src="include/JSON.js"></script>
  <script>
    function uploadCheck(quotes){
      //AJAX call for checking the file size and comparing with php.ini settings.
      var callback = {
        success:function(r) {
          var file_type = r.responseText;
          if(file_type == 'empty'){
            //field empty
          }else{
            if(file_type == 'other_quotes'){
              alert(SUGAR.language.get('Configurator','LBL_ALERT_JPG_IMAGE'));
              document.getElementById("quotes_logo").value='';
            }
            if(file_type == 'other'){
              alert(SUGAR.language.get('Configurator','LBL_ALERT_TYPE_IMAGE'));
              document.getElementById("company_logo").value='';
            }
            if(file_type == 'size_quotes'){
              alert(SUGAR.language.get('Configurator','LBL_ALERT_SIZE_RATIO_QUOTES'));
              document.getElementById("quotes_logo").value='';
            }
            if(file_type == 'size'){
              alert(SUGAR.language.get('Configurator','LBL_ALERT_SIZE_RATIO'));
            }
            //error in getimagesize because unsupported type
            if(file_type.length > 20){
              alert(SUGAR.language.get('Configurator','LBL_ALERT_TYPE_IMAGE'));
              document.getElementById("quotes_logo").value='';
              document.getElementById("company_logo").value='';
            }
            else{
              //image is good
            }
          }
        }
      }
      if(quotes){
        var file_name = document.ConfigureSettings.quotes_logo.value;
        postData = 'file_name=' + JSON.stringify(file_name) + '&module=Configurator&action=UploadFileCheck&to_pdf=1&forQuotes=true';
      }
      else{
        var file_name = document.ConfigureSettings.company_logo.value;
        postData = 'file_name=' + JSON.stringify(file_name) + '&module=Configurator&action=UploadFileCheck&to_pdf=1&forQuotes=false';
      }

      YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, postData);
    }
  </script>
   -->
  {/literal}
</form>
