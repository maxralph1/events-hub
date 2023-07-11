import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner'
import { useTicketTypes } from '@/hooks/useTicketTypes'
import { useEvents } from '@/hooks/useEvents'
import { useCurrencies } from '@/hooks/useCurrencies'
import { useUsers } from '@/hooks/useUsers'
import { useTicket } from '@/hooks/useTicket'
 
function CreateTicket() {
  const navigate = useNavigate()
  const { ticketTypes } = useTicketTypes()
  const { events } = useEvents()
  const { currencies } = useCurrencies()
  const { users } = useUsers()
  const { ticket, createTicket } = useTicket()

 
  async function handleSubmit(ticket) {
    ticket.preventDefault()
 
    await createTicket(ticket.data)
  }
 
  return (
    <form onSubmit={ handleSubmit } noValidate>
      <div className="">
 
        <h1 className="">Add Ticket</h1>

        <div className="">
          <label htmlFor="event_id" className="required">Event</label>
          <select
            id="event_id"
            className=""
            value={ ticket.data.event_id ?? '' }
            onChange={ e => ticket.setData({
              ...ticket.data,
              event_id: e.target.value,
            }) }
            disabled={ ticket.loading }
          >
            { events.length > 0 && events.map((event) => {
              return <option key={ event.id } value={ event.id }>
                { event.name.toUpperCase() }{' '}
                { event.description && '('+event.description+')' }
              </option>
            }) }
          </select>
          <ValidationError errors={ ticket.errors } field="event_id" />
        </div>
 
        <div className="">
          <label htmlFor="ticket_type_id" className="required">Ticket Type</label>
          <select
            id="ticket_type_id"
            className=""
            value={ ticket.data.ticket_type_id ?? '' }
            onChange={ e => ticket.setData({
              ...ticket.data,
              ticket_type_id: e.target.value,
            }) }
            disabled={ ticket.loading }
          >
            { ticketTypes.length > 0 && ticketTypes.map((ticket_type) => {
              return <option key={ ticket_type.id } value={ ticket_type.id }>
                { ticket_type.name }
                { ticket_type.description} {ticket_type.currency.name }
              </option>
            }) }
          </select>
          <ValidationError errors={ ticket.errors } field="ticket_type_id" />
        </div>
{/*  
        <div className="">
          <label htmlFor="currency_id" className="required">Currency</label>
          <select
            id="currency_id"
            className=""
            value={ ticket.data.currency_id ?? '' }
            onChange={ e => ticket.setData({
              ...ticket.data,
              currency_id: e.target.value,
            }) }
            disabled={ ticket.loading }
          >
            { currencies.length > 0 && currencies.map((currency) => {
              return <option key={ currency.id } value={ currency.id }>
                { currency.name.toUpperCase() }{' '}
                { currency.description && '('+currency.description+')' }
              </option>
            }) }
          </select>
          <ValidationError errors={ ticket.errors } field="currency_id" />
        </div> */}
        
 
        <div className="">
          <label htmlFor="user_id" className="required">User</label>
          <select
            id="user_id"
            className=""
            value={ ticket.data.user_id ?? '' }
            onChange={ e => ticket.setData({
              ...ticket.data,
              user_id: e.target.value,
            }) }
            disabled={ ticket.loading }
          >
            { users.length > 0 && users.map((user) => {
              return <option key={ user.id } value={ user.id }>
                { user.name }
                { user.email }
              </option>
            }) }
          </select>
          <ValidationError errors={ ticket.errors } field="user_id" />
        </div>
 
        <div className="">
          <button
            type="submit"
            className=""
            disabled={ ticket.loading }
          >
            { ticket.loading && <IconSpinner /> }
            Save Ticket
          </button>
 
          <button
            type="button"
            className=""
            disabled={ ticket.loading }
            onClick={ () => navigate(route('tickets.index')) }
          >
            <span>Cancel</span>
          </button>
        </div>
      </div>
    </form>
  )
}
 
export default CreateTicket