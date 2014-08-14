# define: nginx::resource::mailhost
#
# This definition creates a virtual host
#
# Parameters:
#   [*ensure*]              - Enables or disables the specified mailhost (present|absent)
#   [*listen_ip*]           - Default IP Address for NGINX to listen with this vHost on. Defaults to all interfaces (*)
#   [*listen_port*]         - Default IP Port for NGINX to listen with this vHost on. Defaults to TCP 80
#   [*listen_options*]      - Extra options for listen directive like 'default' to catchall. Undef by default.
#   [*ipv6_enable*]         - BOOL value to enable/disable IPv6 support (false|true). Module will check to see if IPv6
#                             support exists on your system before enabling.
#   [*ipv6_listen_ip*]      - Default IPv6 Address for NGINX to listen with this vHost on. Defaults to all interfaces (::)
#   [*ipv6_listen_port*]    - Default IPv6 Port for NGINX to listen with this vHost on. Defaults to TCP 80
#   [*ipv6_listen_options*] - Extra options for listen directive like 'default' to catchall. Template will allways add ipv6only=on.
#                             While issue jfryman/puppet-nginx#30 is discussed, default value is 'default'.
#   [*index_files*]         - Default index files for NGINX to read when traversing a directory
#   [*ssl*]                 - Indicates whether to setup SSL bindings for this mailhost.
#   [*ssl_cert*]            - Pre-generated SSL Certificate file to reference for SSL Support. This is not generated by this module.
#   [*ssl_key*]             - Pre-generated SSL Key file to reference for SSL Support. This is not generated by this module.
#   [*ssl_port*]            - Default IP Port for NGINX to listen with this SSL vHost on. Defaults to TCP 443
#   [*starttls*]            - enable STARTTLS support: (on|off|only)
#   [*protocol*]            - Mail protocol to use: (imap|pop3|smtp)
#   [*auth_http*]           - With this directive you can set the URL to the external HTTP-like server for authorization.
#   [*xclient*]             - wheter to use xclient for smtp (on|off)
#   [*server_name*]         - List of mailhostnames for which this mailhost will respond. Default [$name].
#
# Actions:
#
# Requires:
#
# Sample Usage:
#  nginx::resource::mailhost { 'domain1.example':
#    ensure      => present,
#    auth_http   => 'server2.example/cgi-bin/auth',
#    protocol    => 'smtp',
#    listen_port => 587,
#    ssl_port    => 465,
#    starttls    => 'only',
#    xclient     => 'off',
#    ssl         => true,
#    ssl_cert    => '/tmp/server.crt',
#    ssl_key     => '/tmp/server.pem',
#  }
define nginx::resource::mailhost (
  $listen_port,
  $ensure              = 'enable',
  $listen_ip           = '*',
  $listen_options      = undef,
  $ipv6_enable         = false,
  $ipv6_listen_ip      = '::',
  $ipv6_listen_port    = '80',
  $ipv6_listen_options = 'default',
  $ssl                 = false,
  $ssl_cert            = undef,
  $ssl_key             = undef,
  $ssl_port            = undef,
  $starttls            = 'off',
  $protocol            = undef,
  $auth_http           = undef,
  $xclient             = 'on',
  $server_name         = [$name]) {
  File {
    owner => 'root',
    group => 'root',
    mode  => '0644',
  }
  
  validate_array($server_name)

  # Add IPv6 Logic Check - Nginx service will not start if ipv6 is enabled
  # and support does not exist for it in the kernel.
  if ($ipv6_enable and !$::ipaddress6) {
    warning('nginx: IPv6 support is not enabled or configured properly')
  }

  # Check to see if SSL Certificates are properly defined.
  if ($ssl or $starttls == 'on' or $starttls == 'only') {
    if ($ssl_cert == undef) or ($ssl_key == undef) {
      fail('nginx: SSL certificate/key (ssl_cert/ssl_cert) and/or SSL Private must be defined and exist on the target system(s)')
    }
  }

  # Use the File Fragment Pattern to construct the configuration files.
  # Create the base configuration file reference.
  if ($listen_port != $ssl_port) {
    file { "${nginx::config::nx_temp_dir}/nginx.mail.d/${name}-001":
      ensure  => $ensure ? {
        'absent' => absent,
        default  => 'file',
      },
      content => template('nginx/mailhost/mailhost.erb'),
      notify  => Class['nginx::service'],
    }
  }

  # Create SSL File Stubs if SSL is enabled
  if ($ssl) {
    file { "${nginx::config::nx_temp_dir}/nginx.mail.d/${name}-700-ssl":
      ensure  => $ensure ? {
        'absent' => absent,
        default  => 'file',
      },
      content => template('nginx/mailhost/mailhost_ssl.erb'),
      notify  => Class['nginx::service'],
    }
  }
}