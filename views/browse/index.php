<?php
use yii\helpers\Url;
use yii\helpers\Html;

$bundle = \humhub\modules\cfiles\Assets::register($this);
$this->registerJsVar('cfilesUploadUrl', $contentContainer->createUrl('/cfiles/browse/upload', [
    'fid' => $folderId
]));
$this->registerJsVar('cfilesDeleteUrl', $contentContainer->createUrl('/cfiles/browse/delete'));
$this->registerJsVar('cfilesEditFolderUrl', $contentContainer->createUrl('/cfiles/browse/edit-folder', [
    'id' => '--folderId--'
]));
?>
<?php echo Html::beginForm(null, null, ['data-target' => '#globalModal']); ?>
<div class="panel panel-default">

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-10 col-md-9 col-sm-9" id="fileList">
                <?php echo $fileList; ?>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">

                <div id="progress" class="progress"
                    style="display: none">
                    <div class="progress-bar progress-bar-success"></div>
                </div>

                <ul class="nav nav-pills nav-stacked">
                    <li><span class="fileinput-button btn btn-success">
                            <i class="glyphicon glyphicon-plus"></i> <strong>Add
                                file(s)</strong> <input id="fileupload"
                            type="file" name="files[]" multiple>
                    </span></li>
                    <li class="nav-divider"></li>
                    <li><?php echo Html::a('Add directory', $contentContainer->createUrl('/cfiles/browse/edit-folder', ['fid' => $folderId]), array('data-target' => '#globalModal')); ?></li>
                    <?php if ($folderId !== 0) : ?>
                        <li><?php echo Html::a('Edit directory', $contentContainer->createUrl('/cfiles/browse/edit-folder', ['id' => $folderId]), array('data-target' => '#globalModal')); ?></li>
                    <?php endif; ?>
                    <li>
                        <?php
                        echo \humhub\widgets\AjaxButton::widget([
                            'label' => "Delete (<span class='chkCnt'></span>)",
                            'tag' => 'a',
                            'ajaxOptions' => [
                                'type' => 'POST',
                                'success' => new yii\web\JsExpression('function(html){ $("#fileList").html(html); }'),
                                'url' => $contentContainer->createUrl('/cfiles/browse/delete')
                            ],
                            'htmlOptions' => [
                                'class' => 'selectedOnly filedelete-button',
                                'style' => 'display:none'
                            ]
                        ]);
                        ?>
                    </li>
                    <li>
                        <?php
                        echo \humhub\widgets\AjaxButton::widget([
                            'label' => "Move (<span class='chkCnt'></span>)",
                            'tag' => 'a',
                            'ajaxOptions' => [
                                'type' => 'POST',
                                'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); $("#globalModal").modal("show"); openDirectory(' . $folderId . '); selectDirectory(' . $folderId . ');}'),
                                'url' => $contentContainer->createUrl('/cfiles/browse/move-files', [
                                    'init' => 1,
                                    'fid' => $folderId
                                ])
                            ],
                            'htmlOptions' => [
                                'class' => 'selectedOnly filemove-button',
                                'style' => 'display:none'
                            ]
                        ]);
                        ?>
                        <!--<?php
                        
                        echo Html::a("Move (<span class='chkCnt'></span>)", $contentContainer->createUrl('/cfiles/browse/move-files', [
                            'init' => 1
                        ]), array(
                            'data-target' => '#globalModal',
                            'class' => 'selectedOnly filemove-button',
                            'style' => 'display:none',
                            'data-target' => '#globalModal'
                        ));
                        ?>-->
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php echo Html::endForm(); ?>


<ul id="contextMenuFolder" class="contextMenu dropdown-menu" role="menu"
    style="display: none">
    <li><a tabindex="-1" href="#" data-action='download'>Open</a></li>
    <li role="separator" class="divider"></li>
    <li><a tabindex="-1" href="#" data-action='edit'>Edit</a></li>
    <li><a tabindex="-1" href="#" data-action='delete'>Delete</a></li>
</ul>

<ul id="contextMenuFile" class="contextMenu dropdown-menu" role="menu"
    style="display: none">
    <li><a tabindex="-1" href="#" data-action='download'>Download</a></li>
    <li role="separator" class="divider"></li>
    <li><a tabindex="-1" href="#" data-action='delete'>Delete</a></li>
</ul>

<div id="logContainer" style="display: none">
    <ul id="hiddenLog">
    </ul>
</div>
