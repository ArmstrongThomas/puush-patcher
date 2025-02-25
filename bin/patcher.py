import base64
import re

# File paths
original_file = "puush.exe"
patched_file = "puush_patched.exe"

# Old and new domain
old_domain = "puush.me"
# new domain name must be same length as puush.me,
# else you need to change your hosts file and set puush.me
# to whatever IP you're planning to use
new_domain = "yourhost"

# Read the original file in binary mode
with open(original_file, "rb") as f:
    data = f.read()

# Find Base64-encoded strings
base64_patterns = re.findall(rb'[A-Za-z0-9+/=]{20,}', data)

# Patch occurrences of the domain
patched_data = data
for b64_string in base64_patterns:
    try:
        decoded = base64.b64decode(b64_string + b'==='[:len(b64_string) % 4]).decode('utf-8', errors='ignore')
        if old_domain in decoded:
            modified_string = decoded.replace(old_domain, new_domain)
            new_b64 = base64.b64encode(modified_string.encode()).replace(b'\n', b'')
            if len(new_b64) <= len(b64_string):
                # Replace in binary data
                patched_data = patched_data.replace(b64_string, new_b64.ljust(len(b64_string), b'='))
    except Exception:
        continue  # Ignore decoding errors

# Save the patched executable
with open(patched_file, "wb") as f:
    f.write(patched_data)

print(f"Patched executable saved as: {patched_file}")