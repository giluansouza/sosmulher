<?php $v->layout("_theme"); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Perfil do Usuário</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item active">Início</li>
                <li class="breadcrumb-item active">Perfil do usuário</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- Content Wrapper. Contains page content -->
<div class="ajax_response"><?= flash(); ?></div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card card-box">
            <div class="card-header">
                <h3><i class="fa fa-fw fa-clipboard"></i> Ocorrência <?= ($result->type == 1) ? "- BOTÃO DO PÂNICO" : "";  ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <td><strong>Data da denúncia</strong></td>
                                    <td><strong>Denúncia na hora do fato</strong></td>
                                    <td><strong>Denunciante</strong></td>
                                    <td><strong>Situação</strong></td>
                                </tr>
                                <tr>
                                    <td><?= date_fmt($result->created_at, "d/m/Y H:i") ?></td>
                                    <td><?= ($result->real_time == 0) ? "Não" : "Sim" ?></td>
                                    <td><?= $result->plaintiff?:$result->User->name ?></td>
                                    <td><?= ($result->status == 0) ? "Aberta" : ($result->status == 1) ? "Visualizada" : "Encerrada"; ?></td>
                                </tr>
                                <?php if ($result->type == 0): ?>
                                    <tr>
                                        <td colspan="2"><strong>Nome da Vitíma</strong></td>
                                        <td colspan="2"><strong>Nome do Acusado</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?= $result->name_victim ?></td>
                                        <td colspan="2"><?=$result->name_accused ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><strong>Observação</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= $result->note ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><strong>Endereço</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= (isset($result->Address->public_place)) ? $result->Address->public_place.' '.$result->Address->district.' Complemento: '.$result->Address->complement : "NI" ?></td>
                                    </tr>
                                <?php endif ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <form action="<?= url("admin/ocorrencia/status") ?>" method="post">
                    <?= csrf_input(); ?>
                    <input type="hidden" name="occurrence_id" value="<?= $result->id ?>">
                    <?php if ($result->status == 0): ?>
                        <input type="hidden" name="status" value="1">
                        <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-check"></i> Visualizada</button>
                    <?php else: ?>
                        <input type="hidden" name="status" value="2">
                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Finalizar</button>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<?php if ($result->type == 1): ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="maparea" id="map2"></div>
                </div>
            </div><!-- end card-->
        </div>
    </div>
    <div id='data'><?= json_encode($result); ?></div>
    <?php $v->start("scripts") ?>
        <!-- BEGIN Java Script for this page -->
        <script src="//maps.google.com/maps/api/js?key=<?= getenv('GOOGLE_MAPS_APIKEY') ?>"></script>
        <script src="<?= theme("/../superadmin/assets/plugins/gmapsjs/gmaps.js"); ?>"></script>
        <script src="<?= theme("/../../shared/js/unit-map.js"); ?>"></script>
        <!-- END Java Script for this page -->
    <?php $v->end() ?>
<?php endif ?>
