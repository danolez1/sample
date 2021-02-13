<!-- Modal -->
<div class="modal fade" id="selectBranch" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="selectBranchLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectBranchLabel" trn="select-branch">Select Branch</h5>
            </div>
            <div class="modal-body">

                <?php foreach ($this->branches as $branch) { ?>
                    <div class="alert alert-success card-hover select-shop" role="alert" data-id="<?php echo $branch->getId(); ?>">
                        <strong> <?php echo $branch->getName(); ?></strong><br>
                        <?php echo $branch->getLocation(); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>