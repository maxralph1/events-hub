import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner'
import { useEventHalls } from '@/hooks/useEventHalls'
import { useHosts } from '@/hooks/useHosts'
import { useUsers } from '@/hooks/useUsers'
import { useEvent } from '@/hooks/useEvent'
 
function CreateEvent() {
  const navigate = useNavigate()
  const { eventHalls } = useEventHalls()
  const { hosts } = useHosts()
  const { users } = useUsers()
  const { event, createEvent } = useEvent()

 
  async function handleSubmit(event) {
    event.preventDefault()
 
    await createEvent(event.data)
  }
 
  return (
    <form onSubmit={ handleSubmit } noValidate>
      <div className="">
 
        <h1 className="">Add Event</h1>
 
        <div className="">
          <label htmlFor="eventHall_id" className="required">EventHall</label>
          <select
            id="eventHall_id"
            className=""
            value={ event.data.eventHall_id ?? '' }
            onChange={ e => event.setData({
              ...event.data,
              eventHall_id: e.target.value,
            }) }
            disabled={ event.loading }
          >
            { eventHalls.length > 0 && eventHalls.map((eventHall) => {
              return <option key={ eventHall.id } value={ eventHall.id }>
                { eventHall.name.toUpperCase() }{' '}
                { eventHall.description && '('+eventHall.description+')' }
              </option>
            }) }
          </select>
          <ValidationError errors={ event.errors } field="eventHall_id" />
        </div>
 
        <div className="">
          <label htmlFor="host_id" className="required">Host</label>
          <select
            id="host_id"
            className=""
            value={ event.data.host_id ?? '' }
            onChange={ e => event.setData({
              ...event.data,
              host_id: e.target.value,
            }) }
            disabled={ event.loading }
          >
            { hosts.length > 0 && hosts.map((host) => {
              return <option key={ host.id } value={ host.id }>
                { host.name.toUpperCase() }{' '}
                { host.description && '('+host.description+')' }
              </option>
            }) }
          </select>
          <ValidationError errors={ event.errors } field="host_id" />
        </div>

        <div className="">
          <label htmlFor="title" className="">Title</label>
          <input
            id="title"
            name="title"
            type="text"
            value={ event.data.title ?? '' }
            onChange={ e => event.setData({
              ...event.data,
              title: e.target.value,
            }) }
            className=""
            disabled={ event.loading }
          />
          <ValidationError errors={ event.errors } field="title" />
        </div>
 
        <div className="">
          <label htmlFor="description" className="">Description</label>
          <input
            id="description"
            name="description"
            type="text"
            value={ event.data.description ?? '' }
            onChange={ e => event.setData({
              ...event.data,
              description: e.target.value,
            }) }
            className=""
            disabled={ event.loading }
          />
          <ValidationError errors={ event.errors } field="description" />
        </div>
 
        <div className="">
          <label htmlFor="start_date" className="">Start Date</label>
          <input
            id="start_date"
            name="start_date"
            type="date"
            value={ event.data.start_date ?? '' }
            onChange={ e => event.setData({
              ...event.data,
              start_date: e.target.value,
            }) }
            className=""
            disabled={ event.loading }
          />
          <ValidationError errors={ event.errors } field="start_date" />
        </div>
 
        <div className="">
          <label htmlFor="start_time" className="">Start Time</label>
          <input
            id="start_time"
            name="start_time"
            type="time"
            value={ event.data.start_time ?? '' }
            onChange={ e => event.setData({
              ...event.data,
              start_time: e.target.value,
            }) }
            className=""
            disabled={ event.loading }
          />
          <ValidationError errors={ event.errors } field="start_time" />
        </div>

        <div className="">
          <label htmlFor="end_date" className="">End Date</label>
          <input
            id="end_date"
            name="end_date"
            type="date"
            value={ event.data.end_date ?? '' }
            onChange={ e => event.setData({
              ...event.data,
              end_date: e.target.value,
            }) }
            className=""
            disabled={ event.loading }
          />
          <ValidationError errors={ event.errors } field="end_date" />
        </div>
 
        <div className="">
          <label htmlFor="end_time" className="">End Time</label>
          <input
            id="end_time"
            name="end_time"
            type="time"
            value={ event.data.end_time ?? '' }
            onChange={ e => event.setData({
              ...event.data,
              end_time: e.target.value,
            }) }
            className=""
            disabled={ event.loading }
          />
          <ValidationError errors={ event.errors } field="end_time" />
        </div>
 
        <div className="">
          <button
            type="submit"
            className=""
            disabled={ event.loading }
          >
            { event.loading && <IconSpinner /> }
            Save Event
          </button>
 
          <button
            type="button"
            className=""
            disabled={ event.loading }
            onClick={ () => navigate(route('events.index')) }
          >
            <span>Cancel</span>
          </button>
        </div>
      </div>
    </form>
  )
}
 
export default CreateEvent