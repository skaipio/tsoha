<div id="kiireellisyysluokka-muokkaa">
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="nimi" class="col-sm-2 control-label">Luokan nimi</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_etunimi" value="L2">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 control-label">
                Minimivahvuudet
            </div>
        </div>

        <div class="form-group">
            <label for="laakarit" class="col-sm-2 control-label">Lääkärit</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_sukunimi" value="1">
            </div>
        </div>
        <div class="form-group">
            <label for="sairaanhoitajat" class="col-sm-2 control-label">Sairaanhoitajat</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_osoite" value="1">
            </div>
        </div>

        <div class="form-group">
            <label for="perushoitajat" class="col-sm-2 control-label">Perushoitajat</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_sposti" value="1">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default disabled">Tallenna</button>
<!--                <button type="cancel" class="btn btn-default"><a href="?type=kiireellisyysluokat">Peruuta</a></button>-->
                <button type="cancel" class="btn btn-default" href="?type=kiireellisyysluokat">Peruuta</button>
                <button type="cancel" class="btn btn-default disabled">Poista luokka</button>
            </div>
        </div>
    </form>
</div>