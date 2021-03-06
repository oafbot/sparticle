<?php
   $media = self::init()->media;
   $user  = self::init()->user;
   $title = $media->name;
   
   $active_user = Laika_User::active()->id;
   $favorited   = Sparticle_Favorite::init()->is_favorite($active_user, $media->id, $media->type);
?>

<div id="container">
    <div class="controls dark upper">
        <div class="toolbar right">
            <table>
            <tr class="icon">
<!--                 <td><a><? echo EDIT_ICON; ?></a></td> -->
                <td>
                    <a href="javascript:;" onclick="favorite('<? echo $media->id; ?>');">
                        <? echo $favorited ? FAVORITE_ICON : UNFAVORITE_ICON; ?>
                    </a>
                </td>
                <td class="icon">
                    <a href="javascript:;" onclick="enterFullScreen('<? self::init()->fullscreen(); ?>');">
                        <? echo FULLSCREEN_ICON; ?>
                    </a>
                </td>
            </tr>
            <tr class="icon-label">
<!--                 <td>Edit</td> -->
                <td class="favorite"><? echo $favorited ? 'Undo' : 'Favorite'; ?></td>
                <td>Fullscreen</td>
            </tr>
            </table>
        </div>
    </div>
    <div id=content>
        <div id="image">
            <a href="javascript:;" onclick="enterFullScreen('<? self::init()->fullscreen(); ?>');" >
                <img src=<? echo Laika_Image::api_path( $media->path, 'auto', '500' ); ?> />
            </a>
        </div>
        <div id="info">
            <div id="owner"> 
                <? echo $user->avatar(35); ?>
            </div> 
            <div id="title">            
                <h1 id="image_name"><? echo !empty($title) ? $title : "Untitled"; ?></h1>
                by <? self::link_to($user->username, '/user/'.$user->username, array('class'=>'user')); ?>
            </div> 

            <p id="description">
                <? echo $media->description; ?> 
            </p>
            <div id="details">
                <h2>Details:</h2>
                <? echo PICTURE_ICON; ?>&nbsp;
                <a href="<? echo $media->path; ?>" target="blank" >Original size: </a>
                <? echo Laika_Image::dimensions($media->path); ?>
                <br />
                <? echo CLOUD_ICON; ?>&nbsp;
                <? echo "Added: ".$media->created_to_date(); ?>
                <br />
                <? echo $favorited ? FAVORITE_ICON : UNFAVORITE_ICON; ?>&nbsp;
                <span class = "favorite_count">
                <? echo Sparticle_Favorite::count(array('item'=>$media->id)); ?>
                </span> Favorites 
            </div>
        </div>
    </div>
</div>
    
<?php
    /* RENDER COMMENT MODULE */
    $param = array("parent_type"=>$media->type, "parent_id"=>$media->id);
    self::render('comment',$param); 
?>