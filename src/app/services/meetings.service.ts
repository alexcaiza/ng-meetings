import { Injectable } from '@angular/core';
import { AppSettings } from '../utils/app-settings';
import { Observable, of, throwError } from 'rxjs';
import { catchError, tap, map } from 'rxjs/operators';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';

@Injectable({
    providedIn: 'root'
})
export class MeetingsService {

    constructor(private httpClient: HttpClient) { }

    saveMeetingEstudiante(form: any): Observable<any> {

        console.log(form);

        const url = `${AppSettings.baseUrl}/saveMeetingEstudiante.php?estudianteid=${form?.estudianteid}}`;
        return this.httpClient.post(url, form, AppSettings.httpOptions).pipe(
            tap(_ => console.log(`params: ${form}`)),
            catchError(AppSettings.handleError<any>('saveMeetingEstudiante'))
        );
    }

    workflowMeeting(form: any): Observable<any> {

        console.log('form:');
        console.log(form);

        const url = `${AppSettings.baseUrl}/workflowMeeting.php?meetingid=${form?.meetingid}}`;
        return this.httpClient.post(url, form, AppSettings.httpOptions).pipe(
            tap(_ => console.log(`params: ${form}`)),
            catchError(AppSettings.handleError<any>('workflowMeeting'))
        );
    }

    findMeetingStatusById(form: any): Observable<any> {

        console.log('form:');
        console.log(form);

        const url = `${AppSettings.baseUrl}/findMeetingStatusById.php?meetingid=${form?.meetingid}}`;
        return this.httpClient.post(url, form, AppSettings.httpOptions).pipe(
            tap(_ => console.log(`params: ${form}`)),
            catchError(AppSettings.handleError<any>('findMeetingStatusById'))
        );
    }

    cancelMeetingEstudiante(form: any): Observable<any> {

        console.log(form);

        const url = `${AppSettings.baseUrl}/cancelMeetingEstudiante.php?meetingid=${form?.meetingid}}`;
        return this.httpClient.post(url, form, AppSettings.httpOptions).pipe(
            tap(_ => console.log(`params: ${form}`)),
            catchError(AppSettings.handleError<any>('cancelMeetingEstudiante'))
        );
    }
}
