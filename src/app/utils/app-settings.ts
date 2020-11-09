import { HttpHeaders} from '@angular/common/http';
import { Observable, of, throwError } from 'rxjs';

export class AppSettings {

    optionsMessages = {
        autoClose: false,
        keepAfterRouteChange: false
    };

    public static baseUrl: string = "http://localhost/ng-meetings/backend";

    public static httpOptions = {
        headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    public static handleError<T>(operation = 'operation', result?: T) {
        return (error: any): Observable<T> => {

            // TODO: send the error to remote logging infrastructure
            console.error(error); // log to console instead

            // Let the app keep running by returning an empty result.
            return of(result as T);
        };
    }
}
