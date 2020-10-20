import { Injectable, Output, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { Observable, of, throwError } from 'rxjs';
import { catchError, tap, map } from 'rxjs/operators';
import { Horario } from './horario';
import { Profesor } from './profesor';
import { Meeting } from './meeting';

@Injectable({
    providedIn: 'root'
})
export class DataserviceService {

    httpOptions = {
        headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    redirectUrl: string;

    baseUrl: string = "http://localhost/ng-meetings/backend";

    @Output()
    getLoggedInName: EventEmitter<any> = new EventEmitter();

    constructor(private httpClient: HttpClient) { }

    getHoras(params): Observable<any> {
        const url = `${this.baseUrl}/findProfesorFechaHorarios.php`;

        //return this.httpClient.get<any>(url);

        return this.httpClient.post(url, params, this.httpOptions).pipe(
            tap(_ => console.log(`params=${params}`)),
            catchError(this.handleError<any>('updateTodo'))
        );

    }

    findEstudianteMeeting(params): Observable<any> {
        const url = `${this.baseUrl}/findEstudianteMeeting.php`;
        return this.httpClient.post(url, params, this.httpOptions).pipe(
            tap(_ => console.log(`params=${params}`)),
            catchError(this.handleError<any>('findEstudianteMeeting')));
    }

    private handleError<T>(operation = 'operation', result?: T) {
        return (error: any): Observable<T> => {

            // TODO: send the error to remote logging infrastructure
            console.error(error); // log to console instead

            // Let the app keep running by returning an empty result.
            return of(result as T);
        };
    }

    findProfesores(): Observable<Profesor[]> {
        const url = `${this.baseUrl}/findProfesores.php`;
        return this.httpClient.get<Profesor[]>(url);
    }

    public loginUser(cedula, email) {
        console.log('method loginUser');
        return this.httpClient.post<any>(this.baseUrl + '/login.php', { cedula, email })
            .pipe(map(data => {
                console.log('data: ');
                console.log(data);
                if (data.user) {
                    console.log('user: ');
                    console.log(data.user);

                    if (data.typeUser == 'ESTUDIANTE') {
                        this.setToken(data.user.estudianteid);
                        this.setEstudiante(JSON.stringify(data.user));
                    } 
                    else {
                        this.setToken(data.user.profesorid);
                        this.setProfesor(JSON.stringify(data.user));
                    }
                    this.getLoggedInName.emit(true);
                    
                   
                } 
                return data;
            }));

    }
    public userregistration(name, email, pwd, mobile) {
        return this.httpClient.post<any>(this.baseUrl + '/registration.php', { name, email, pwd, mobile })
            .pipe(map(Usermodule => {
                return Usermodule;
            }));
    }
    //token
    setToken(token: string) {
        localStorage.setItem('token', token);
    }

    setEstudiante(estudiante) {
        localStorage.setItem('estudiante', estudiante);
    }

    setProfesor(profesor) {
        localStorage.setItem('profesor', profesor);
    }

    getEstudiante() {
        return localStorage.getItem('estudiante');
    }

    getProfesor() {
        return localStorage.getItem('profesor');
    }

    getToken() {
        return localStorage.getItem('token');
    }

    deleteToken() {
        localStorage.removeItem('token');
    }

    isLoggedIn() {
        const usertoken = this.getToken();
        if (usertoken != null) {
            return true
        }
        return false;
    }

    getMeetingsProfesor(profesor) {
        const url = `${this.baseUrl}/findProfesorMeetingsList.php`;
        //return this.httpClient.get<Profesor[]>(url);
       // return this.httpClient.get<any>('assets/books.json')
       return this.httpClient.post<any>(url, profesor).pipe(
        tap(_ => console.log(`params=${profesor}`)),
        catchError(this.handleError<any>('findEstudianteMeeting')));
       }

}