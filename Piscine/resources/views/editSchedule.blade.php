@extends('navbars.navbarSeller')

@section('content')

    <h1> Horaires du magasin </h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <form class ="form-inline" method="POST">
                    <div class="col-lg-3">
                        {{  csrf_field()  }}
                        <h4> Ajouter un horaire </h4>
                    </div>
                    <div class="col-lg-6 form-inline">
                        <div class="form-group">
                            <select name="day" >
                                @foreach($days as $day)
                                    <option value="{{$day->nomJour}}">{{$day->nomJour}}</option>
                                    @if ($errors->has('day'))
                                        <small class="alert alert-danger" role="alert"> {{ $errors->first('day') }} </small>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong> De </strong></label>
                            <input name="start" type="time" placeholder="08:00">
                            @if ($errors->has('start'))
                                <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('start') }} </div></small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label><strong> à </strong></label>
                            <input name="end" type="time" placeholder="08:00">
                            @if ($errors->has('end'))
                                <small class="alert alert-danger" role="alert"> {{ $errors->first('end') }} </small>
                            @endif
                        </div>
                        <div class="form-group">
                            <input hidden name="siretNumber" value="{{$siretNumber}}">
                            <button type="submit" class=" btn btn-success" name="add"> Ajouter </button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(isset($daysOfShop))
    <div class="container-fluid">
        <div class="row">
            @foreach($schedules as $schedule)
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h4 class="text-center"> {{$schedule->nomJour}} </h4>
                        @foreach ($daysOfShop->where('nomJour', $schedule->nomJour) as $dayOfShop)
                        <div class="col-lg-12">
                            <form class ="form-inline text-center" style="display: inline-block" method="POST">
                                {{  csrf_field()  }}
                                <input hidden name="id" value="{{$dayOfShop->numOuvrir}}">
                                <div class="form-group">
                                    <div class="col-lg-3"><label><strong> horaire :</strong> </label></div>
                                    <div class="col-lg-2"> <input type="time" name="start" value="{{$dayOfShop->debut}}"></div>
                                    <div class="col-lg-2"> <input type="time" name="end" value="{{$dayOfShop->fin}}"></div>
                                    <div class="col-lg-5">
                                        <button type="submit" class="btn-sm btn-info " name="edit"> éditer </button>
                                        <button type="submit" class="btn-sm btn-danger" name="delete"> X </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
            @endforeach
        </div>
    </div>
    @endif



@endsection