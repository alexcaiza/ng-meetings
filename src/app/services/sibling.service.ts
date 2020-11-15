import { Injectable } from '@angular/core';

import { Observable, Subject, BehaviorSubject } from 'rxjs'

@Injectable({
  providedIn: 'root'
})
export class SiblingService {

  public callToggle = new Subject();
  public subjectDocentesList = new BehaviorSubject(null);
  public siblingDocentesList$ = this.subjectDocentesList.asObservable();
  public findMeetingsProfesor: Function;

  constructor() { }

  public setDocentesList(data:any) {
    this.subjectDocentesList.next(data);
  }
}
