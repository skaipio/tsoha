<div id="tyontekija-muokkaa">
    <h4>Lääkäri Väiski Vemmelsääri</h4>
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="etunimi" class="col-sm-2 control-label">Etunimi</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_etunimi" value="Väiski">
            </div>
        </div>
        <div class="form-group">
            <label for="sukunimi" class="col-sm-2 control-label">Sukunimi</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_sukunimi" value="Vemmelsääri">
            </div>
        </div>
        <div class="form-group">
            <label for="osoite" class="col-sm-2 control-label">Osoite</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_osoite" value="Acmekatu 2, Jollywood">
            </div>
        </div>
        
        <div class="form-group">
            <label for="sahkoposti" class="col-sm-2 control-label">Sähköposti</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_sposti" value="vvemmel@lasema.fi">
            </div>
        </div>
        <div class="form-group">
            <label for="gsmnumero" class="col-sm-2 control-label">GSM</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_gsmnumero" value="1234567890">
            </div>
        </div>
        <div class="form-group">
            <label for="henkilostoluokka" class="col-sm-2 control-label">Henkilöstöluokka</label>
            <div class="col-sm-5">
                <select class="form-control">
                    <option>Lääkäri</option>
                    <option>Sairaanhoitaja</option>
                    <option>Perushoitaja</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="maxtunnitpaivassa" class="col-sm-2 control-label">Maksimi tunnit päivässä</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_maxtunnitpaivassa" value="12">
            </div>
        </div>
        <div class="form-group">
            <label for="maxtunnitviikossa" class="col-sm-2 control-label">Maksimi tunnit viikossa</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tyontekija_maxtunnitviikossa" value="60">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default disabled">Tallenna</button>
                <a href="?type=tyontekija"><button class="btn btn-default" type="button">Peruuta</button></a>
                <button type="cancel" class="btn btn-default disabled">Poista työntekijä</button>
            </div>
        </div>
    </form>
</div>