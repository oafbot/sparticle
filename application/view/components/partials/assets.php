<? $id = Sparticle_Media::find('path',$object->path)->id(); ?>                    
<? $count++; if(($count+2)%3 == 0) echo '<tr>'; ?>
<td>
<div class=box>
    <? self::img( Laika_Image::api_path($object->path,'auto', 200),
        array('onclick'=>"toggle_selection($id)",'class'=>'unselected','id'=>'image'.$id)); ?>
    <br />                                        
    <input type="checkbox" value="<? echo $id; ?>" name="<? echo $label; ?>" 
        onclick="toggle_selection(<? echo $id ?>)" id=<? echo 'checkbox'.$id; ?> />         
    <h3 id=<? echo 'name'.$id ?> >
        <? 
        Sparticle_Media::find('path',$object->path)->name() != NULL ? 
        $name = Sparticle_Media::find('path',$object->path)->name() : 
        $name = "Image #".$id;
        echo $name; 
        ?>
    </h3>                
</div>
</td>
<? if($count%3 == 0) echo '</tr>'; ?>