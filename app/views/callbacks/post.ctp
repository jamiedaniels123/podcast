

 <form action="/callbacks/add" method="post" enctype="application/x-www-form-urlencoded" name="action" id="action">
 
 <select name="data[command]">
 <option value="">Select action ...</option>
 <option value="status-media">Status Media</option>
 <option value="status-encoder">Status Encoder</option>
 <option value="transcode-media">C - Transcode media</option>
 <option value="transcode-media-and-deliver">C - Transcode-media-and-deliver</option>
 <option value="transfer-file-to-media-server">C - Transfer-file-to-media-server</option>
 <option value="transfer-folder-to-media-server">C - Transfer-folder-to-media-server</option>
 <option value="delete-file-on-media-server">D - Delete-file(s)-on-media-server</option>
 <option value="delete-folder-on-media-server">D - Delete-folder-on-media-server</option>
 <option value="update-file-metadata">U - Update-file(s)-metadata</option>
 <option value="update-folder-metadata">U - Update-folder-metadata</option>
 <option value="set-permissions-folder">R - Set-permissions-folder (media-server)</option>
 <option value="check-file-exists">D - Check-file(s)-exists (media-server)</option>
 <option value="check-folder-exists">D - Check-folder-exists (media-server)</option>
 </select>
 
<input type="text" name="data[number]" value="1"/>
<input type="text" name="data[target_path]"value="1467_testforcharles/"/>
<input type="text" name="data[filename]" value="12537_BSG_4.2.avi"/>
<input type="text" name="data[source_path]" value="1467_testforcharles/"/>
<input type="text" name="data[target_filename]" value="12537_BSG_4.2.avi"/>
<input type="text" name="data[status]" value="1"/>

<input type="submit">
 </form>