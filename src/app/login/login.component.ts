import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators, NgForm } from '@angular/forms';
import { first } from 'rxjs/operators';
import { Router } from '@angular/router';
import { DataserviceService } from '../services/dataservice.service';
import { AlertService } from '../_alert';

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

    optionsAlert = {
        autoClose: true,
        keepAfterRouteChange: false
    };

    angForm: FormGroup;

    constructor(
        private fb: FormBuilder,
        private dataService: DataserviceService,
        private router: Router,
        protected alertService: AlertService
    ) {
        this.buildForm();
    }

    ngOnInit() {
    }

    private buildForm() {
        this.angForm = this.fb.group({
            cedula: ['100', [Validators.required]],
            email: ['a@a.com', [Validators.required, Validators.minLength(1), Validators.email]]
        });
    }

    get f() { return this.angForm.controls; }


    onSubmit(form) {
        console.log(form.value)
    }


    postdata(angForm1: FormGroup) {

        console.log('postdata method');

        console.log(angForm1.value);
        console.log('dataService.redirectUrl: ' + this.dataService.redirectUrl);

        this.dataService.loginUser(angForm1.value.cedula, angForm1.value.email)
            //.pipe(first())
            .subscribe(
                data => {
                    console.log('subscribe data');
                    console.log(data);

                    if (data) {
                        if (data.user && data.typeUser) {
                            //const redirect = this.dataService.redirectUrl ? this.dataService.redirectUrl : '/dashboard';
                            let redirect = "";
                            
                            if (data.typeUser === 'ESTUDIANTE') {
                                redirect = this.dataService.redirectUrl ? this.dataService.redirectUrl : '/estudiantes/estudiantes-meeting-list';
                            } else if (data.typeUser === 'PROFESOR') {
                                redirect = this.dataService.redirectUrl ? this.dataService.redirectUrl : '/docentes/docentes-meeting-list';
                            }

                            console.log('redirect');
                            console.log(redirect);

                            this.router.navigate([redirect]);
                        } else {
                            if (data.mensaje) {
                                this.alertService.error(data.mensaje, this.optionsAlert);
                            }
                        }
                    } else {
                        this.alertService.error('Los datos son incorrectos!!', this.optionsAlert);
                    }
                },
                error => {
                    //alert("User name or password is incorrect")
                    this.alertService.error('Los datos son incorrectos!!', this.optionsAlert);
                });
    }

    get email() { return this.angForm.get('email'); }

    get password() { return this.angForm.get('password'); }
}