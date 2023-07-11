import PropTypes from 'prop-types'

const ValidationError = ({ errors, field }) => {
  return errors?.[field]?.length &&
  <div className="" role="alert">
    <ul>
      { errors[field].map((error, index) => {
        return (<li key={ index }>{ error }</li>)
      }) }
    </ul>
  </div>
}

ValidationError.propTypes = {
  errors: PropTypes.object.isRequired,
  field: PropTypes.string.isRequired,
}

export default ValidationError