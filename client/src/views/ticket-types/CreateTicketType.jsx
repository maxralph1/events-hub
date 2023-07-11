import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner'
import { useHosts } from '@/hooks/useHosts'
import { useUsers } from '@/hooks/useUsers'
import { useTicketType } from '@/hooks/useTicketType'
 
function CreateTicketType() {
  const navigate = useNavigate()
  const { hosts } = useHosts()
  const { users } = useUsers()
  const { ticketType, createTicketType } = useTicketType()


  async function handleSubmit(ticketType) {
    ticketType.preventDefault()
 
    await createTicketType(ticketType.data)
  }
 
  return (
    <form onSubmit={ handleSubmit } noValidate>
      <div className="">
 
        <h1 className="">Add TicketType</h1>
 
        <div className="">
          <label htmlFor="event_id" className="required">Event</label>
          <select
            id="event_id"
            className=""
            value={ ticketType.data.event_id ?? '' }
            onChange={ e => ticketType.setData({
              ...ticketType.data,
              event_id: e.target.value,
            }) }
            disabled={ ticketType.loading }
          >
            { events.length > 0 && events.map((event) => {
              return <option key={ event.id } value={ event.id }>
                { event.title} {event.description }
              </option>
            }) }
          </select>
          <ValidationError errors={ ticketType.errors } field="event_id" />
        </div>

        <div className="">
          <label htmlFor="title" className="">Title</label>
          <input
            id="title"
            name="title"
            type="text"
            value={ ticketType.data.title ?? '' }
            onChange={ e => ticketType.setData({
              ...ticketType.data,
              title: e.target.value,
            }) }
            className=""
            disabled={ ticketType.loading }
          />
          <ValidationError errors={ ticketType.errors } field="title" />
        </div>
 
        <div className="">
          <label htmlFor="description" className="">Description</label>
          <input
            id="description"
            name="description"
            type="text"
            value={ ticketType.data.description ?? '' }
            onChange={ e => ticketType.setData({
              ...ticketType.data,
              description: e.target.value,
            }) }
            className=""
            disabled={ ticketType.loading }
          />
          <ValidationError errors={ ticketType.errors } field="description" />
        </div>
 
        <div className="">
          <label htmlFor="available_tickets" className="">Available Tickets</label>
          <input
            id="available_tickets"
            name="available_tickets"
            type="text"
            value={ ticketType.data.available_tickets ?? '' }
            onChange={ e => ticketType.setData({
              ...ticketType.data,
              available_tickets: e.target.value,
            }) }
            className=""
            disabled={ ticketType.loading }
          />
          <ValidationError errors={ ticketType.errors } field="available_tickets" />
        </div>
 
        <div className="">
          <label htmlFor="price" className="">Price</label>
          <input
            id="price"
            name="price"
            type="text"
            value={ ticketType.data.price ?? '' }
            onChange={ e => ticketType.setData({
              ...ticketType.data,
              price: e.target.value,
            }) }
            className=""
            disabled={ ticketType.loading }
          />
          <ValidationError errors={ ticketType.errors } field="price" />
        </div>

        <div className="">
          <label htmlFor="currency_id" className="required">Currency</label>
          <select
            id="currency_id"
            className=""
            value={ ticketType.data.currency_id ?? '' }
            onChange={ e => ticketType.setData({
              ...ticketType.data,
              currency_id: e.target.value,
            }) }
            disabled={ ticketType.loading }
          >
            { currencys.length > 0 && currencys.map((currency) => {
              return <option key={ currency.id } value={ currency.id }>
                { currency.name.toUpperCase() }{' '}
                { currency.description && '('+currency.description+')' }
              </option>
            }) }
          </select>
          <ValidationError errors={ ticketType.errors } field="currency_id" />
        </div>
 
        <div className="">
          <button
            type="submit"
            className=""
            disabled={ ticketType.loading }
          >
            { ticketType.loading && <IconSpinner /> }
            Save TicketType
          </button>
 
          <button
            type="button"
            className=""
            disabled={ ticketType.loading }
            onClick={ () => navigate(route('ticketTypes.index')) }
          >
            <span>Cancel</span>
          </button>
        </div>
      </div>
    </form>
  )
}

export default CreateTicketType