import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DocentesMeetingListComponent } from './docentes-meeting-list.component';

describe('DocentesMeetingListComponent', () => {
  let component: DocentesMeetingListComponent;
  let fixture: ComponentFixture<DocentesMeetingListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DocentesMeetingListComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DocentesMeetingListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
